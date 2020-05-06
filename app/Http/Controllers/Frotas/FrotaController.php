<?php

namespace sgcom\Http\Controllers\Frotas;

use Illuminate\Support\Facades\DB;
use sgcom\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use sgcom\Models\Opm;
use sgcom\Models\MarcaVeiculo;
use sgcom\Models\ModeloVeiculo;
use Illuminate\Http\Request;
use sgcom\Models\SituacaoViatura;
use sgcom\Models\Viatura;
use sgcom\Models\Combustivel;
use sgcom\Models\TipoPneu;
use sgcom\Models\Bateria;
use sgcom\Models\Efetivo;

class FrotaController extends Controller
{
  private $totalPage = 15;

  public function __construct()
  {
  }

  public function dadosGerais()
  {
    $usr = Auth::user();
    $opmt = $usr->efetivo->opm_id;
    $cprId = $usr->efetivo->opm->cpr_id;

    if ($usr->existePapel('Gestor CPR')) {
      $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=', $cprId)->get();
    } else if ($usr->existePapel('Admin')) {
      $opms = Opm::orderBy('opm_sigla', 'asc')->get();
    } else {
      $opms = Opm::orderBy('opm_sigla', 'asc')->where('id', '=', $opmt)->get();
    }

    $marcaveiculos = MarcaVeiculo::orderBy('descricao', 'asc')->get();
    $modeloveiculos = ModeloVeiculo::orderBy('descricao', 'asc')->get();
    $situacaoviaturas = SituacaoViatura::orderBy('descricao', 'asc')->get();
    $combustiveis = Combustivel::orderBy('descricao', 'asc')->get();
    $tipopneus = TipoPneu::orderBy('descricao', 'asc')->get();
    $baterias = Bateria::orderBy('descricao', 'asc')->get();
    $total = Viatura::whereNotIn('situacao_viatura_id', [1, 6])->where('opm_id', '=', $usr->efetivo->opm->id)->count();
    $baixadas = Viatura::whereIn('situacao_viatura_id', [4, 5])->where('opm_id', '=', $usr->efetivo->opm->id)->count();
    $operantes = Viatura::whereIn('situacao_viatura_id', [2, 3, 6])->where('opm_id', '=', $usr->efetivo->opm->id)->count();
    view()->share(compact(
      'total',
      'opms',
      'marcaveiculos',
      'baterias',
      'baixadas',
      'operantes',
      'modeloveiculos',
      'situacaoviaturas',
      'combustiveis',
      'tipopneus'
    ));
  }

  public function index(Viatura $viatura)
  {
    $this->dadosGerais();
    $revisoes = [];
    $historicos = [];
    return view('frota.index', compact('viatura', 'revisoes', 'historicos'));
  }

  public function lista()
  {
    $this->dadosGerais();
    $usr = Auth::user();
    $viaturas = Viatura::whereNotIn('situacao_viatura_id', [1])->where('opm_id', '=', $usr->efetivo->opm->id)->orderBy('prefixo')->paginate($this->totalPage);
    return view('frota.lista', compact('viaturas'));
  }

  public function salvar(Request $request)
  {

    $viatura = new viatura();
    try {
      if ($request->id != null)
        $viatura = Viatura::find($request->id);

      $this->validate($request, [
        'placa' => 'required|min:3',

      ]);

      $viatura->placa = strtoupper($request->placa);
      $viatura->opm_id  = $request->opm;
      $viatura->modelo_veiculo_id = $request->modeloveiculo;
      $viatura->marca_veiculo_id  = $request->marcaveiculo;
      $viatura->prefixo  = $request->prefixo;
      $viatura->chassi  = $request->chassi;
      $viatura->renavam  = $request->renavam;
      $viatura->patrimonio  = $request->patrimonio;
      $viatura->combustivel_id  = $request->combustivel;
      $viatura->situacao_viatura_id  = $request->situacao;
      $viatura->ano_modelo  = $request->anomodelo;
      $viatura->ano_fabricacao  = $request->anofabricacao;
      $viatura->tipo_pneu_id  = $request->tipopneu;
      $viatura->km  = $request->km;
      $viatura->cor =   $request->cor;
      $viatura->emprego = $request->emprego;
      $viatura->bateria_id = $request->bateria;
      $viatura->propriedade = $request->propriedade;
      $viatura->plotagem = $request->plotagem;
      $viatura->presidio = $request->presidio;
      $viatura->km_por_revisao = $request->kmrevisao;

      $retorno =  $viatura->save();

      if ($retorno)
        return redirect()->route('frota.lista')->with('success', 'Viatura inserida');
    } catch (\Exception $e) {
      $errors = $e->getMessage();

      return redirect()->back()->with('error', 'Falha ao inserir!');
    }
  }

  public function edit($id)
  {
    $this->dadosGerais();

    $viatura = Viatura::find($id);
    $revisoes = null;
    $historicos = null;
    if ($viatura) {
      $revisoes =  DB::select('select * from viatura_revisao where viatura_id = ? order by data desc', [$viatura->id]);
      $historicos =  DB::select('select hv.data, hv.observacao,thv.nome from historico_viatura hv
       , tipo_historico_viatura thv where hv.tipo_historico_viatura_id = thv.id and viatura_id = ? order by data desc', [$viatura->id]);
    }

    return view('frota.index', compact('viatura', 'revisoes', 'historicos'));
  }

  public function editKM($id)
  {
    $viatura = Viatura::find($id);
    if (!$viatura) {
      abort(404);
    }

    return view('frota.form_km', compact('viatura'));
  }

  public function salvarKM(Request $request)
  {

    $viatura = new viatura();
    $usr = Auth::user();
    try {
      if ($request->id != null)
        $viatura = Viatura::find($request->id);

      DB::insert(
        'insert into viatura_km (viatura_id, data, hora,km, user_id) values (?,?,?,?,?)',
        [$viatura->id, $request->data, $request->hora, $request->km, $usr->id]
      );

      DB::update('update viatura set km = ? where id = ?', [$request->km, $viatura->id]);

      return redirect()->route('frota.lista')->with('success', 'KM atualizado');
    } catch (\Exception $e) {
      $errors = $e->getMessage();

      return redirect()->back()->with('error', 'Falha ao inserir!');
    }
  }

  public function editRevisao($id)
  {
    $viatura = Viatura::findOrFail($id);
    $revisoes = null;
    if ($viatura) {
      $revisoes =  DB::select('select * from viatura_revisao where viatura_id = ?', [$viatura->id]);
    }

    return view('frota.form_revisao', compact('viatura', 'revisoes'));
  }

  public function salvarRevisao(Request $request)
  {
    // dd($request->all());
    $viatura = new viatura();
    $usr = Auth::user();
    try {
      if ($request->id != null)
        $viatura = Viatura::find($request->id);

      DB::insert(
        'insert into viatura_revisao (viatura_id, data, local,km,servicos, user_id) values (?,?,?,?,?,?)',
        [$viatura->id, $request->data_rev, $request->local_rev, $request->km_rev, $request->servico_rev, $usr->id]
      );

      DB::update('update viatura set ultima_revisao_km = ? , ultima_revisao_data = ? where id = ?', [$request->km_rev, $request->data_rev, $viatura->id]);

      return redirect()->route('frota.lista')->with('success', 'KM atualizado');
    } catch (\Exception $e) {
      $errors = $e->getMessage();

      return redirect()->back()->with('error', 'Falha ao inserir!');
    }
  }

  public function editHistorico($id)
  {
    $this->dadosGerais();

    $viatura = Viatura::findOrFail($id);
    $tipos = DB::select('select id, nome from tipo_historico_viatura');
    /* if($viatura){
       $revisoes=  DB::select('select * from viatura_revisao where viatura_id = ? order by data desc', [$viatura->id]);
      }  */
    // dd($revisoes);
    return view('frota.form_historico', compact('viatura', 'tipos'));
  }

  public function salvarHistorico(Request $request)
  {
    //dd($request->all());
    $viatura = new viatura();
    $usr = Auth::user();
    try {
      if ($request->id != null)
        //$viatura = Viatura::findOrFail($request->id);

        DB::insert(
          'insert into historico_viatura (viatura_id, data, observacao,tipo_historico_viatura_id,user_id) values (?,?,?,?,?)',
          [$request->id, $request->data, $request->observacao, $request->tipo, $usr->id]
        );


      return redirect()->route('frota.lista')->with('success', 'Histórico atualizado');
    } catch (\Exception $e) {
      $errors = $e->getMessage();

      return redirect()->back()->with('error', 'Falha ao inserir!');
    }
  }

  public function search(Request $request, Viatura $viatura)
  {
    // dd($request->all());
    $this->dadosGerais();

    $dataForm = $request->except('_token');

    $viaturas =  $viatura->search($dataForm, $this->totalPage);
    // dd($efetivos);

    return view('frota.lista', compact('viaturas', 'dataForm'));
  }
}
