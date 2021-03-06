<?php

namespace sgcom\Http\Controllers\RecursosHumanos;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use sgcom\Http\Controllers\Controller;
use sgcom\Models\Opm;
use sgcom\Models\Efetivo;
use sgcom\Models\GrauHierarquico;
use Illuminate\Support\Facades\Auth;
use sgcom\Models\Cpr;
use sgcom\Models\Secao;
use sgcom\Models\Funcao;
use sgcom\Models\HistoricoPolicial;
use sgcom\Models\SituacaoEfetivo;
use sgcom\Models\TipoHistorico;
use sgcom\Service\EfetivoService;
use sgcom\User;

class EfetivoController extends Controller
{

  private $totalPage = 100;
  private $efetivoService;

  public function __construct()
  {
    $this->efetivoService = new EfetivoService();
  }

  public function dadosGerais()
  {
    $usr = Auth::user();
    $opmId = $usr->efetivo->opm_id;
    $cprId = $usr->efetivo->opm->cpr_id;
    $opmTotal = $this->getEfetivoTotalOpm($opmId);
    $cprTotal = $this->getEfetivoTotalCpr($cprId);
    $previsao = $this->getPrevisaoGH($opmId);
    $realEfetivo = $this->getEfetivoRealGH($opmId);
    $realEfetivoCpr = $this->getEfetivoRealGHCpr($cprId);
    $previsaoTotalCpr = $this->getPrevisaoTotalCpr($cprId);
    $previsaoTotalOpm = $this->getPrevisaoTotalOpm($opmId);
    $porSexo = ($this->agrupamentoSexo($opmId));
    $porSexoCpr = ($this->agrupamentoSexoCpr($cprId));
    $agrupamento = $this->agrupamentoTempoServicoCpr($cprId);
    $agrupamentoIdade = $this->agrupamentoIdadeCpr($cprId);
    $agrupamentoOpm = $this->agrupamentoTempoServicoOpm($opmId);
    $agrupamentoIdadeOpm = $this->agrupamentoIdadeOpm($opmId);

    if ($usr->existePapel('Gestor CPR')) {
      $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=', $cprId)->get();
    } else if ($usr->existePapel('Admin')) {
      $opms = Opm::orderBy('opm_sigla', 'asc')->get();
    } else {
      $opms = Opm::orderBy('opm_sigla', 'asc')->where('id', '=', $opmId)->get();
    }


    $ghs = GrauHierarquico::where('precedencia','<=',15)->orderBy('precedencia', 'asc')->get();
    $secoes = Secao::orderBy('nome', 'asc')->get();
    $funcoes = Funcao::orderBy('nome', 'asc')->get();
    $situacoes = SituacaoEfetivo::orderBy('nome', 'asc')->get();
    $cprs = Cpr::whereIn('id', [4, 11, 12])->get();
    $bairros = Efetivo::select(DB::raw('distinct(bairro)'))->where('bairro', '<>', 'null')->get();
    $cidades = Efetivo::select(DB::raw('distinct(cidade_estado)'))->where('cidade_estado', '<>', 'null')->get();

    $ferias = Efetivo::where('situacao_efetivo_id', '=', 3)->where('opm_id', '=', $opmId)->count();
    $jms = Efetivo::where('situacao_efetivo_id', '=', 6)->where('opm_id', '=', $opmId)->count();
    $agregados = Efetivo::where('situacao_efetivo_id', '=', 5)->where('opm_id', '=', $opmId)->count();
    $adm_com = Efetivo::where('situacao_efetivo_id', '=', 2)->where('opm_id', '=', $opmId)->count();
    $adm_sem = Efetivo::where('situacao_efetivo_id', '=', 7)->where('opm_id', '=', $opmId)->count();
    $gestantes = Efetivo::where('situacao_efetivo_id', '=', 4)->where('opm_id', '=', $opmId)->count();

    return view()->share(compact(
      'agrupamentoIdade',
      'agrupamento',
      'agrupamentoIdadeOpm',
      'agrupamentoOpm',
      'opmTotal',
      'cprTotal',
      'previsao',
      'realEfetivo',
      'previsaoTotalCpr',
      'previsaoTotalOpm',
      'porSexo',
      'porSexoCpr',
      'jms',
      'agregados',
      'opms',
      'ghs',
      'secoes',
      'funcoes',
      'situacoes',
      'cprs',
      'bairros',
      'cidades',
      'ferias',
      'gestantes',
      'adm_com',
      'adm_sem',
      'realEfetivoCpr'
    ));
  }


  public function index()
  {
    $this->dadosGerais();
    $efetivos = Efetivo::where('opm_id', '999')->paginate($this->totalPage);
    $usr = Auth::user();
    $opm = $usr->efetivo->opm_id;

    return view('recursoshumanos.listageral', compact('efetivos'));
  }

  public function resumoEfetivo()
  {
    $this->dadosGerais();
    $efetivos = [];
    $usr = Auth::user();
    $opmId = $usr->efetivo->opm_id;

    $efet_situacao = DB::table('pmgeral')
      ->where('pmgeral.opm_id', $opmId)
      ->join('situacao_efetivo', 'pmgeral.situacao_efetivo_id', '=', 'situacao_efetivo.id')
      ->select(DB::raw('situacao_efetivo.nome, count(*) as total'))
      ->groupBy('situacao_efetivo.nome')
      ->get();

    $efet_funcao = DB::table('pmgeral')
      ->where('pmgeral.opm_id', $opmId)
      ->join('funcao', 'pmgeral.funcao_id', '=', 'funcao.id')
      ->select(DB::raw('funcao.nome, count(*) as total'))
      ->groupBy('funcao.nome')
      ->get();

    //dd($efet_situacao);
    return view('recursoshumanos.resumoEfetivo', compact('efetivos', 'efet_situacao', 'efet_funcao'));
  }

  public function resumoEfetivoSearch(Request $request)
  {
    $this->dadosGerais();
    $efetivos = [];
    $usr = Auth::user();
    $opmId = $request->popm;

    $efet_situacao = DB::table('pmgeral')
      ->where('pmgeral.opm_id', $opmId)
      ->join('situacao_efetivo', 'pmgeral.situacao_efetivo_id', '=', 'situacao_efetivo.id')
      ->select(DB::raw('situacao_efetivo.nome, count(*) as total'))
      ->groupBy('situacao_efetivo.nome')
      ->get();

    $efet_funcao = DB::table('pmgeral')
      ->where('pmgeral.opm_id', $opmId)
      ->join('funcao', 'pmgeral.funcao_id', '=', 'funcao.id')
      ->select(DB::raw('funcao.nome, count(*) as total'))
      ->groupBy('funcao.nome')
      ->get();

    //dd($efet_situacao);
    return view('recursoshumanos.resumoEfetivo', compact('efetivos', 'efet_situacao', 'efet_funcao'));
  }

  public function retornoRemover($opm_id)
  {
    $this->dadosGerais();
    $efetivo = new Efetivo();
    $efetivos = $efetivo->porOpm($opm_id, $this->totalPage);

    return view('recursoshumanos.listageral', compact('efetivos'));
  }

  public function search(Request $request, Efetivo $efetivo)
  {
    $this->dadosGerais();
    $dataForm = $request->except('_token');

    $efetivos =  $efetivo->searchUnique($dataForm, $this->totalPage);

    return view('recursoshumanos.listageral', compact('efetivos', 'dataForm'));
  }

  public function searchHistorico(Request $request, HistoricoPolicial $historico)
  {
    $this->dadosGerais();
    $dataForm = $request->except('_token');

    $historicos =  $historico->searchHistorico($dataForm, $this->totalPage);
    $efetivo = Efetivo::find($dataForm['id']);
    $tiposhistorico = TipoHistorico::all();
    return view('recursoshumanos.historico', compact('tiposhistorico', 'efetivo', 'historicos', 'dataForm'));
  }
  public function edit($id)
  {
    $efetivo = Efetivo::find($id);
    if (!$efetivo) {
      abort(404);
    }
    $this->dadosGerais();
    return view('recursoshumanos.form', compact('efetivo'));
  }

  public function view($id)
  {
    $efetivo = Efetivo::find($id);
    if (!$efetivo) {
      abort(404);
    }
    return view('recursoshumanos.form_view', compact('efetivo'));
  }

  public function voltar()
  {
    return redirect()->back();
  }

  public function salvar(Request $request)
  {
    //dd($request->all());
    $efetivo = new Efetivo();
    try {
      if ($request->id != null)
        $efetivo = Efetivo::find($request->id);


      $efetivo->nome                  = $request->nome;
      $efetivo->dataadmissao          = $request->data_admissao;
      $efetivo->datanascimento        = $request->data_nascimento;
      $efetivo->opm_id                = $request->opm;
      $efetivo->grauhierarquico_id    = $request->gh;
      $efetivo->fatorrh               = $request->fatorrh;
      $efetivo->tiposangue            = $request->tiposangue;
      $efetivo->matricula             = $request->matricula;
      $efetivo->sexo                  = $request->sexo;

      $efetivo->cnh                   = $request->cnh;
      $efetivo->categoria_cnh         = $request->categoriacnh;
      $efetivo->eh_motorista          = $request->ehmotorista;
      $efetivo->motorista_tipo        = $request->motoristatipo;
      $efetivo->validade_cnh          = $request->validadecnh;

      $efetivo->funcao_id             = $request->funcao;
      $efetivo->secao_id              = $request->secao;

      $efetivo->formacao_academica    = $request->formacao;
      $efetivo->area_conhecimento     = $request->areaconhecimento;
      $efetivo->curso_academico       = $request->cursoacademico;
      $efetivo->ano_conclusao         = $request->anoconclusao;

      $efetivo->situacao_efetivo_id   = $request->situacao;
      $efetivo->endereco            = $request->endereco;
      $efetivo->bairro              = $request->bairro;
      $efetivo->numero                = $request->numero;
      $efetivo->complemento           = $request->complemento;
      $efetivo->cidade_estado         = $request->cidade_estado;
      $efetivo->cep                   = $request->cep;
      $efetivo->telefone              = $request->telefone;
      $efetivo->email                 = $request->email;

      if ($request->hasfile('arquivo') && $request->file('arquivo')->isvalid()) {
        $extension = $request->arquivo->extension();
        $nameFile = "{$efetivo->matricula}.{$extension}";

        $path  =  $request->file('arquivo')->move('fotos', $nameFile);
        $efetivo->foto =  $path;
      }

      $efetivo->save();

      return redirect()->back()->with('success', 'Atualizado com sucesso!');
    } catch (\Exception $e) {
      $errors = $e->getMessage();
      return redirect()->back()->withErrors('errors')->withInput();
    }
  }

  public function getMatricula($id)
  {
    $efetivo =  DB::table('pmgeral')
      ->where('matricula', $id)
      ->get();

    return response()->json($efetivo);
  }

  public function getPrevisaoGH($opm)
  {
    $cel = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3470)
      ->sum('total');

    $tencel = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3460)
      ->sum('total');

    $maj = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3450)
      ->sum('total');

    $cap = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3440)
      ->sum('total');

    $ten = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3430)
      ->sum('total');

    $subten = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3400)
      ->sum('total');

    $sgt = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3390)
      ->sum('total');

    $cb = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3340)
      ->sum('total');

    $sd = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3330)
      ->sum('total');

    $retorno = '[' . $cel . ',' . $tencel . ',' . $maj . ',' . $cap . ',' . $ten . ',' . $subten . ',' . $sgt . ',' . $cb . ',' . $sd . ']';
    return $retorno;
  }

  public function getPrevisaoGHCpr($cpr)
  {
    $cel = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3470)
      ->sum('total');

    $tencel = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3460)
      ->sum('total');

    $maj = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3450)
      ->sum('total');

    $cap = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3440)
      ->sum('total');

    $ten = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3430)
      ->sum('total');

    $subten = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3400)
      ->sum('total');

    $sgt = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3390)
      ->sum('total');

    $cb = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3340)
      ->sum('total');

    $sd = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3330)
      ->sum('total');

    $retorno = '[' . $cel . ',' . $tencel . ',' . $maj . ',' . $cap . ',' . $ten . ',' . $subten . ',' . $sgt . ',' . $cb . ',' . $sd . ']';
    return $retorno;
  }


  public function getPrevisaoTotalCpr($cpr)
  {
    $prev = DB::table('distribuicao_efetivo')
      ->join('opm', 'distribuicao_efetivo.opm_id', 'opm.id')
      ->where('opm.cpr_id', $cpr)
      ->sum('total');
    return $prev;
  }

  public function getPrevisaoTotalOpm($opm)
  {
    $prev = DB::table('distribuicao_efetivo')
      ->where('opm_id', $opm)
      ->sum('total');
    return $prev;
  }

  public function getEfetivoRealGH($opm)
  {
    $cel = DB::table('pmgeral')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3470)
      ->count();

    $tencel = DB::table('pmgeral')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3460)
      ->count();

    $maj = DB::table('pmgeral')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3450)
      ->count();

    $cap = DB::table('pmgeral')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3440)
      ->count();

    $ten = DB::table('pmgeral')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3430)
      ->count();

    $subten = DB::table('pmgeral')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3400)
      ->count();

    $sgt = DB::table('pmgeral')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3390)
      ->count();

    $cb = DB::table('pmgeral')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3340)
      ->count();

    $sd = DB::table('pmgeral')
      ->where('opm_id', $opm)
      ->where('grauhierarquico_id', 3330)
      ->count();

    $retorno = '[' . $cel . ',' . $tencel . ',' . $maj . ',' . $cap . ',' . $ten . ',' . $subten . ',' . $sgt . ',' . $cb . ',' . $sd . ']';
    return $retorno;
  }


  public function getEfetivoRealGHCpr($cpr)
  {
    $cel = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->where('opm.cpr_id', $cpr)
      ->where('grauhierarquico_id', 3470)
      ->count();

    $tencel = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->where('opm.cpr_id', $cpr)
      ->where('grauhierarquico_id', 3460)
      ->count();

    $maj = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->where('opm.cpr_id', $cpr)
      ->where('grauhierarquico_id', 3450)
      ->count();

    $cap = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->where('opm.cpr_id', $cpr)
      ->where('grauhierarquico_id', 3440)
      ->count();

    $ten = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->where('opm.cpr_id', $cpr)
      ->where('grauhierarquico_id', 3430)
      ->count();

    $subten = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->where('opm.cpr_id', $cpr)
      ->where('grauhierarquico_id', 3400)
      ->count();

    $sgt = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->where('opm.cpr_id', $cpr)
      ->where('grauhierarquico_id', 3390)
      ->count();

    $cb = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->where('opm.cpr_id', $cpr)
      ->where('grauhierarquico_id', 3340)
      ->count();

    $sd = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->where('opm.cpr_id', $cpr)
      ->where('grauhierarquico_id', 3330)
      ->count();

    $retorno = '[' . $cel . ',' . $tencel . ',' . $maj . ',' . $cap . ',' . $ten . ',' . $subten . ',' . $sgt . ',' . $cb . ',' . $sd . ']';
    return $retorno;
  }


  public function getEfetivoTotalCpr($cpr)
  {
    $efetivoCpr = Efetivo::join('opm', 'opm_id', '=', 'opm.id')
      ->where('opm.cpr_id', $cpr)->count();
    return $efetivoCpr;
  }

  public function getEfetivoTotalOpm($opm)
  {
    $efetivoOpm = Efetivo::where('opm_id', $opm)
      ->count();
    return $efetivoOpm;
  }


  public function getPrevisaoFeriasCpr($cprId)
  {
    return $previsaoferias = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->where('opm.cpr_id', '=', $cprId)
      ->whereMonth('dataadmissao', '=', date('m'))
      ->select('nome', 'opm.opm_sigla', 'dataadmissao')
      ->orderBy('grauhierarquico_id', 'desc')
      ->get();
  }

  public function getAniversarioMesCpr($cprId)
  {
    return $aniversarios = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->where('opm.cpr_id', '=', $cprId)
      ->whereMonth('datanascimento', '=', date('m'))
      ->select('nome', 'opm.opm_sigla', 'datanascimento')
      ->orderBy('grauhierarquico_id', 'desc')
      ->get();
  }


  public function getAniversarioDiaCpr($cprId)
  {
    return $aniversarios = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->where('opm.cpr_id', '=', $cprId)
      ->whereMonth('datanascimento', '=', date('m'))
      ->whereDay('datanascimento', '=', date('d'))
      ->select('nome', 'opm.opm_sigla', 'datanascimento')
      ->orderBy('grauhierarquico_id', 'desc')
      ->get();
  }

  /*
     Agrupamento por Sexo OPM
    */
  public function agrupamentoSexo($opmId)
  {
    return $porSexo = DB::table('pmgeral')
      ->select(DB::raw('count(case when sexo =  "F" then 0 end) as F, count(case when sexo = "M"  then 0 end) as M '))
      ->where('opm_id', '=', $opmId)
      ->get();
  }

  public function agrupamentoSexoCpr($cprId)
  {
    return $porSexo = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(case when sexo = "F" then 0 end) as F, 
       count(case when sexo = "M" then 0 end) as M '))
      ->where('opm.cpr_id', '=', $cprId)
      ->get();
  }

  public function agrupamentoTempoServicoOpm($opmId)
  {
    $m_30 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE())) as M_30
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE()) >= 30')
      ->where('opm.id', '=', $opmId)
      ->count();

    $m_25_29 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE())) as M_25_29
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE()) >= 25')
      ->whereRaw('TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE()) <= 29')
      ->where('opm.id', '=', $opmId)
      ->count();

    $m_20_24 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE())) as M_20_24
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE()) >= 20')
      ->whereRaw('TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE()) <= 24')
      ->where('opm.id', '=', $opmId)
      ->count();

    $m_20 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE())) as M_20
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE()) <= 20')
      ->where('opm.id', '=', $opmId)
      ->count();

    $retorno = '[' . $m_20 . ',' . $m_20_24 . ',' . $m_25_29 . ',' . $m_30 . ']';
    return $retorno;
  }

  public function agrupamentoIdadeOpm($opmId)
  {
    $m_30 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , datanascimento,CURDATE())) as M_30
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , datanascimento,CURDATE()) >= 56')
      ->where('opm.id', '=', $opmId)
      ->count();

    $m_25_29 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , datanascimento,CURDATE())) as M_25_29
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , datanascimento,CURDATE()) >= 46')
      ->whereRaw('TIMESTAMPDIFF(YEAR , datanascimento,CURDATE()) <= 55')
      ->where('opm.id', '=', $opmId)
      ->count();

    $m_20_24 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , datanascimento,CURDATE())) as M_20_24
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , datanascimento,CURDATE()) >= 36')
      ->whereRaw('TIMESTAMPDIFF(YEAR , datanascimento,CURDATE()) <= 45')
      ->where('opm.id', '=', $opmId)
      ->count();

    $m_20 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , datanascimento,CURDATE())) as M_20
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , datanascimento,CURDATE()) <= 35')
      ->where('opm.id', '=', $opmId)
      ->count();

    $retorno = '[' . $m_20 . ',' . $m_20_24 . ',' . $m_25_29 . ',' . $m_30 . ']';
    return $retorno;
  }

  public function agrupamentoTempoServicoCpr($cprId)
  {
    $m_30 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE())) as M_30
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE()) >= 30')
      ->where('opm.cpr_id', '=', $cprId)
      ->count();

    $m_25_29 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE())) as M_25_29
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE()) >= 25')
      ->whereRaw('TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE()) <= 29')
      ->where('opm.cpr_id', '=', $cprId)
      ->count();

    $m_20_24 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE())) as M_20_24
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE()) >= 20')
      ->whereRaw('TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE()) <= 24')
      ->where('opm.cpr_id', '=', $cprId)
      ->count();

    $m_20 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE())) as M_20
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , dataadmissao,CURDATE()) <= 20')
      ->where('opm.cpr_id', '=', $cprId)
      ->count();

    $retorno = '[' . $m_20 . ',' . $m_20_24 . ',' . $m_25_29 . ',' . $m_30 . ']';
    return $retorno;
  }

  public function agrupamentoIdadeCpr($cprId)
  {
    $m_30 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , datanascimento,CURDATE())) as M_30
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , datanascimento,CURDATE()) >= 56')
      ->where('opm.cpr_id', '=', $cprId)
      ->count();

    $m_25_29 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , datanascimento,CURDATE())) as M_25_29
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , datanascimento,CURDATE()) >= 46')
      ->whereRaw('TIMESTAMPDIFF(YEAR , datanascimento,CURDATE()) <= 55')
      ->where('opm.cpr_id', '=', $cprId)
      ->count();

    $m_20_24 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , datanascimento,CURDATE())) as M_20_24
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , datanascimento,CURDATE()) >= 36')
      ->whereRaw('TIMESTAMPDIFF(YEAR , datanascimento,CURDATE()) <= 45')
      ->where('opm.cpr_id', '=', $cprId)
      ->count();

    $m_20 = DB::table('pmgeral')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->select(DB::raw('
       count(TIMESTAMPDIFF(YEAR , datanascimento,CURDATE())) as M_20
        '))
      ->whereRaw('TIMESTAMPDIFF(YEAR , datanascimento,CURDATE()) <= 35')
      ->where('opm.cpr_id', '=', $cprId)
      ->count();

    $retorno = '[' . $m_20 . ',' . $m_20_24 . ',' . $m_25_29 . ',' . $m_30 . ']';
    return $retorno;
  }



  public function removerDaOpm($id)
  {
    /*  $usr = Auth::user();
   
      $opm_id = $usr->efetivo->opm_id;
     */
    $efetivo = Efetivo::find($id);
    if (!$efetivo) {
      abort(404);
    }

    $opm_id = $efetivo->opm_id;
    $efetivo->opm_id = 3099991;

    $update = $efetivo->save();
    if ($update)
      return $this->retornoRemover($opm_id);
  }

  public function aniversariantes()
  {
    $usr = Auth::user();
    $opmId = $usr->efetivo->opm_id;
    $cprid = $usr->efetivo->opm->cpr_id;

    $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=', $cprid)->get();
    $aniversarios = $this->efetivoService->getAniversarioMes($cprid);

    return view('recursoshumanos.aniversariantes', compact('opms', 'aniversarios'));
  }

  public function previsaoferias()
  {
    $usr = Auth::user();
    $opmId = $usr->efetivo->opm_id;
    $cprid = $usr->efetivo->opm->cpr_id;

    $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=', $cprid)->get();
    $previsaoFerias = $this->efetivoService->getPrevisaoFeriasCpr($cprid);

    return  view('recursoshumanos.previsao-ferias', compact('opms', 'previsaoFerias'));
  }

  public function pesquisaPrevisaoferias(Request $request, Efetivo $efetivo)
  {
    // dd($request->all());
    $dataForm = $request->all();
    $usr = Auth::user();
    $opmId = $usr->efetivo->opm_id;
    $cprid = $usr->efetivo->opm->cpr_id;
    $previsaoFerias =  $efetivo->pesquisaFerias($dataForm, $this->totalPage);
    $this->dadosGerais();
    // dd($aniversarios);
    $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=', $cprid)->get();
    return view('recursoshumanos.previsao-ferias', compact('opms', 'previsaoFerias', 'dataForm'));
  }

  public function pesquisaAniversarios(Request $request, Efetivo $efetivo)
  {
    // dd($request->all());
    $dataForm = $request->all();

    $aniversarios =  $efetivo->pesquisaAniversarios($dataForm, $this->totalPage);
    $this->dadosGerais();
    // dd($aniversarios);
    return view('recursoshumanos.aniversariantes', compact('aniversarios', 'dataForm'));
  }

  public function historicopolicial($id)
  {

    $this->dadosGerais();
    $historicos = HistoricoPolicial::where('efetivo_id', $id)
      ->orderBy('data_inicio', 'DESC')
      ->paginate($this->totalPage);
    $efetivo = Efetivo::find($id);

    $tiposhistorico = TipoHistorico::all();

    return view('recursoshumanos/historico', compact('historicos', 'efetivo', 'tiposhistorico'));
  }


  public function historiconovo($id)
  {

    $this->dadosGerais();

    $efetivo = Efetivo::find($id);

    $tiposhistorico = TipoHistorico::all();

    return view('recursoshumanos/form_historico', compact('efetivo', 'tiposhistorico'));
  }

  public function salvarhistorico(Request $request)
  {
    //  dd($request->all());
    try {
      $efetivo = Efetivo::find($request->id);
      $historico = new HistoricoPolicial();

      $historico->data_inicio = $request->data_inicio;
      $historico->data_fim = $request->data_fim;
      $historico->observacao = $request->obs;
      $historico->tipo_historico_id = $request->tipo;
      $historico->efetivo_id = $efetivo->id;
      //dd($historico);
      $historico->save();

      return redirect()->back()->with('success', 'Atualizado com sucesso!');
    } catch (\Exception $e) {
      $errors = $e->getMessage();
      return redirect()->back()->withErrors('errors')->withInput();
    }
  }

  public function getCep($cep)
  {
    $retorno =
      $this->efetivoService->getCep($cep);

    return json_encode($retorno);
  }

  public function policiais()
  {
    $this->dadosGerais();

    $policiais = DB::table('pmgeral')
      ->join('grauhierarquico', 'pmgeral.grauhierarquico_id', '=', 'grauhierarquico.id')
      ->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
      ->where('matricula', '=', 1)
      ->select('pmgeral.id', 'opm_sigla', 'matricula', 'nome', 'grauhierarquico.sigla')
      ->orderBy('grauhierarquico.precedencia', 'ASC')->get();


    return view('admin.efetivo.index', compact('policiais'));
  }

  public function getPolicial(Request $request, Efetivo $efetivo)
  {
    $this->dadosGerais();
    $dataForm = $request->except('_token');

    $policiais =  $efetivo->searchUnique($dataForm, $this->totalPage);

    return view('admin.efetivo.index', compact('policiais', 'dataForm'));
  }

  public function editPolicial($id)
  {
    $efetivo = Efetivo::find($id);
    if (!$efetivo) {
      abort(404);
    }
    $this->dadosGerais();
    return view('admin.efetivo.form', compact('efetivo'));
  }

  public function salvarMovimentacao(Request $request)
  {
    //  dd($request->all());
    try {
      $efetivo = Efetivo::find($request->id);
      $efetivo->opm_id = $request->opm;
      $efetivo->grauhierarquico_id = $request->gh;
      $efetivo->save();

      return redirect()->back()->with('success', 'Atualizado com sucesso!');
    } catch (\Exception $e) {
      $errors = $e->getMessage();
      return redirect()->back()->withErrors('errors')->withInput();
    }
  }


  public function getSecoes($id)
  {
    $ret = DB::table('opm')->where('id', '=', $id)->get();

    if ($ret[0]->tipo_secao == 2) {

      $secoes =  DB::table('secao')
        ->whereIn('tipo', [1, 2])
        ->get(['id', 'nome']);
      return response()->json($secoes);
    } else if ($ret[0]->tipo_secao == 3) {

      $secoes =  DB::table('secao')
        ->whereIn('tipo', [1, 3])
        ->get(['id', 'nome']);
      return response()->json($secoes);
    }
  }

  public function incluirPolicial()
  {
     
    $opms = Opm::orderBy('opm_sigla', 'asc')->get();

    $ghs = GrauHierarquico::orderBy('precedencia', 'asc')->where('precedencia', '<=', 16)->get();

    $pms = $this->policiaisBuscar();


    return view('admin.efetivo.incluir', compact('ghs', 'opms','pms'));
  
  }

  public function incluirSalvarPolicial(Request $request)
  {
   //   dd($request->all());
    try {
      $codigo = DB::table('pmgeral')->max('id');
      $efetivo = new Efetivo();
      $efetivo->id = $codigo + 1;
      $efetivo->opm_id = $request->opm;
      $efetivo->grauhierarquico_id = $request->gh;
      $efetivo->nome =  trim(mb_strtoupper($request->nome,'UTF-8'));
      $efetivo->matricula = $request->matricula;
      $efetivo->save();

      return redirect()->back()->with('success', 'Inserido com sucesso!');
    } catch (\Exception $e) {
      $errors = $e->getMessage();
      return redirect()->back()->withErrors([$errors])->withInput();
    }
  }



  public function policiaisBuscar()
  {
    $policiais = DB::table('pmgeral')
      ->join('grauhierarquico', 'pmgeral.grauhierarquico_id', '=', 'grauhierarquico.id')
      ->select('pmgeral.id', 'matricula', 'nome')
     // ->where('matricularh','=',null)
      ->orderBy('grauhierarquico.precedencia', 'ASC')->get(); 
   //  dd($policiais);
    return $policiais;
  }

  public function atualizarPolicial(Request $request)
  {
    
    $opms = Opm::orderBy('opm_sigla', 'asc')->get();

    $ghs = GrauHierarquico::orderBy('precedencia', 'asc')->where('precedencia', '<=', 18)->get();

    $pms = $this->policiaisBuscar();

    try{
      foreach($pms as $pm){
        $rh  = substr($pm->matricula, 0, 8);
        DB::update('update pmgeral set matricularh = ? where id = ?', [$rh, $pm->id]);
      }
      return response('OK', 200)
      ->header('Content-Type', 'text/plain');  
    }catch (\Exception $e){
          return response($content)
            ->withHeaders([
                'Content-Type' => $type,
                'X-Header-One' => 'Header Value',
                'X-Header-Two' => 'Header Value',
            ]);
    }
    
    return view('admin.efetivo.incluir', compact('ghs', 'opms','pms'));
  
  }

}
