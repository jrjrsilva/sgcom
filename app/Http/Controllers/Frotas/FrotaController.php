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

class FrotaController extends Controller
{
    private $totalPage = 15;
  
    public function __construct() {
      $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=','12')->get();
      $marcaveiculos = MarcaVeiculo::orderBy('descricao', 'asc')->get();
      $modeloveiculos = ModeloVeiculo::orderBy('descricao', 'asc')->get();
      $situacaoviaturas = SituacaoViatura::orderBy('descricao','asc')->get();
      $combustiveis = Combustivel::orderBy('descricao','asc')->get();
      $tipopneus = TipoPneu::orderBy('descricao','asc')->get();
      $baterias = Bateria::orderBy('descricao','asc')->get();
      view()->share(compact('opms','marcaveiculos','baterias',
      'modeloveiculos','situacaoviaturas','combustiveis','tipopneus'));
    }
    
    public function index(Viatura $viatura)
      {
        return view('frota.index',compact('viatura'));
      }
  
    public function lista()
      {
        $viaturas = Viatura::orderBy('prefixo')->paginate($this->totalPage);
        return view('frota.lista',compact('viaturas'));
      }
  
    public function salvar(Request $request)
    {  
  
      $viatura = new viatura();
  
        if($request->id != null)
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
  
            $retorno =  $viatura->save();

            if($retorno)
            return redirect()->route('frota.lista')->with('success','Viatura inserida');

            return redirect()->back()->with('error', 'Falha ao inserir!');
            
    }

    public function edit($id)
    {
      $viatura = Viatura::find($id);
      if(!$viatura){
        abort(404);
      }
      
      return view('frota.index', compact('viatura'));
     
    }

    public function search(Request $request, Viatura $viatura)
    {
      // dd($request->all());
      $dataForm = $request->except('_token');
 
      $viaturas =  $viatura->search($dataForm, $this->totalPage);
     // dd($efetivos);

      return view('frota.lista',compact('viaturas','dataForm'));
    }
}
