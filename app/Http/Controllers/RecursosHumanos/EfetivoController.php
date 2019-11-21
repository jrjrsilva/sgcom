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
use sgcom\Models\Secao;
use sgcom\Models\Funcao;
use sgcom\Models\SituacaoEfetivo;

class EfetivoController extends Controller
{
  
    private $totalPage = 100;

    public function __construct() {
     // $opms = Opm::orderBy('opm_sigla', 'asc')->get();
      $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=','12')->get();
      $ghs = GrauHierarquico::orderBy('precedencia','asc')->get();
      $secoes = Secao::orderBy('nome','asc')->get();
      $funcoes = Funcao::orderBy('nome','asc')->get();
      $situacoes = SituacaoEfetivo::orderBy('nome','asc')->get();
     
      view()->share(compact('opms','ghs','secoes','funcoes','situacoes'));
    }
 
    public function dadosGerais()
    {
      $usr = Auth::user();
      $opmt = $usr->efetivo->opm_id;
      $cprt = $usr->efetivo->opm->cpr_id;
      $opmTotal = $this->getEfetivoTotalOpm($opmt);
      $cprTotal = $this->getEfetivoTotalCpr($cprt);
      $previsao = $this->getPrevisaoGH($opmt);
      $realEfetivo = $this->getEfetivoRealGH($opmt);
      $previsaoTotalCpr = $this->getPrevisaoTotalCpr($cprt);
      $previsaoTotalOpm = $this->getPrevisaoTotalOpm($opmt);
      $porSexo = ($this->agrupamentoSexo($opmt));
      
     return view()->share(compact('opmTotal','cprTotal','previsao','realEfetivo','previsaoTotalCpr','previsaoTotalOpm','porSexo'));
    }


    public function index()
    {
     $this->dadosGerais();

   /*   $efetivos = Efetivo::join('grauhierarquico','pmgeral.grauhierarquico_id','=','grauhierarquico.id')
                          ->orderBy('grauHierarquico.precedencia','asc')->paginate($this->totalPage);*/
       $efetivos = Efetivo::where('opm_id','999')->paginate($this->totalPage);
     
       $usr = Auth::user();
   
       $opm = $usr->efetivo->opm_id;
    
      $aniversarios = DB::table('pmgeral')
        ->select('*')
        ->whereDay('datanascimento', date('d'))
        ->whereMonth('datanascimento',date('m'))
        ->where('opm_id', $opm)->get();

      return view('recursoshumanos.listageral',compact('efetivos','aniversarios','valor'));
    }

    public function searchMatricula(Request $request, Efetivo $efetivo)
    {
      $this->dadosGerais();
      $dataForm = $request->except('_token');
 
      $efetivos =  $efetivo->searchUnique($dataForm, $this->totalPage);

      return view('recursoshumanos.listageral',compact('efetivos','dataForm'));
    }

    public function edit($id)
    {
      $efetivo = Efetivo::find($id);
      if(!$efetivo){
        abort(404);
      }
      return view('recursoshumanos.form', compact('efetivo'));
    }

    public function detalhe($id)
    {
      $efetivo = Efetivo::find($id);
      if(!$efetivo){
        abort(404);
      }
      return view('recursoshumanos.detalhe', compact('efetivo'));
    }

    public function voltar(){
      return redirect()->back();
    }

    public function salvar(Request $request)
    {
    //dd($request->all());
      $efetivo = new Efetivo();
      try{      
      if($request->id != null)
        $efetivo = Efetivo::find($request->id);

        $efetivo->nome                = $request->nome;
        $efetivo->dataadmissao        = $request->data_admissao;
        $efetivo->datanascimento      = $request->data_nascimento;
        $efetivo->opm_id              = $request->opm;
        $efetivo->grauhierarquico_id  = $request->gh;
        $efetivo->fatorrh             = $request->fatorrh;
        $efetivo->tiposangue          = $request->tiposangue;
        $efetivo->matricula           = $request->matricula;
        $efetivo->sexo                = $request->sexo;
        
        $efetivo->cnh                 = $request->cnh;
        $efetivo->categoria_cnh       = $request->categoriacnh;
        $efetivo->eh_motorista        = $request->ehmotorista;
        $efetivo->motorista_tipo      = $request->motoristatipo;
        $efetivo->validade_cnh        = $request->validadecnh;
        
        $efetivo->funcao_id           = $request->funcao;
        $efetivo->secao_id            = $request->secao;
        
        $efetivo->formacao_academica  = $request->formacao;
        $efetivo->area_conhecimento   = $request->areaconhecimento;
        $efetivo->curso_academico     = $request->cursoacademico;
        $efetivo->ano_conclusao       = $request->anoconclusao;
        
        $efetivo->situacao_efetivo_id = $request->situacao;
        $efetivo->endereco            = $request->endereco;
        $efetivo->telefone            = $request->telefone;
        $efetivo->email               = $request->email;

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
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3470)
      ->sum('total');

      $tencel = DB::table('distribuicao_efetivo')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3460)
      ->sum('total');

      $maj = DB::table('distribuicao_efetivo')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3450)
      ->sum('total');

      $cap = DB::table('distribuicao_efetivo')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3440)
      ->sum('total');

      $ten = DB::table('distribuicao_efetivo')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3430)
      ->sum('total');

      $subten = DB::table('distribuicao_efetivo')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3400)
      ->sum('total');

      $sgt = DB::table('distribuicao_efetivo')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3390)
      ->sum('total');

      $cb = DB::table('distribuicao_efetivo')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3340)
      ->sum('total');

      $sd = DB::table('distribuicao_efetivo')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3330)
      ->sum('total');
       
      $retorno = '['.$cel.','.$tencel.','.$maj.','.$cap.','.$ten.','.$subten.','.$sgt.','.$cb.','.$sd.']';
      return $retorno;
    }

    public function getPrevisaoTotalCpr($cpr)
    {
      $prev = DB::table('distribuicao_efetivo')
      ->join('opm','distribuicao_efetivo.opm_id','opm.id')
      ->where('opm.cpr_id',$cpr)
      ->sum('total');
      return $prev;
    }

    public function getPrevisaoTotalOpm($opm)
    {
      $prev = DB::table('distribuicao_efetivo')
      ->where('opm_id',$opm)
      ->sum('total');
      return $prev;
    }

    public function getEfetivoRealGH($opm)
    {
      $cel = DB::table('pmgeral')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3470)
      ->count();

      $tencel = DB::table('pmgeral')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3460)
      ->count();

      $maj = DB::table('pmgeral')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3450)
      ->count();

      $cap = DB::table('pmgeral')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3440)
      ->count();

      $ten = DB::table('pmgeral')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3430)
      ->count();

      $subten = DB::table('pmgeral')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3400)
      ->count();

      $sgt = DB::table('pmgeral')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3390)
      ->count();

      $cb = DB::table('pmgeral')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3340)
      ->count();

      $sd = DB::table('pmgeral')
      ->where('opm_id',$opm)
      ->where('grauhierarquico_id',3330)
      ->count();
       
      $retorno = '['.$cel.','.$tencel.','.$maj.','.$cap.','.$ten.','.$subten.','.$sgt.','.$cb.','.$sd.']';
      return $retorno;
    }


    public function getEfetivoTotalCpr($cpr)
    {
      $efetivoCpr = Efetivo::join('opm','opm_id','=','opm.id')
      ->where('opm.cpr_id',$cpr)->count();
      return $efetivoCpr;
    }

    public function getEfetivoTotalOpm($opm)
    {
      $efetivoOpm = Efetivo::where('opm_id',$opm)
      ->count();
      return $efetivoOpm;
    }


    public function getAniversarioMes()
    {
      $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=','12')->get();
     return $aniversarios = Efetivo::where('datanascimento','=',day(now))->get();
    }

    /*
     Agrupamento por Sexo
    */
    public function agrupamentoSexo($opmt)
    {
       return $porSexo = DB::table('pmgeral')
       ->select(DB::raw('count(case when sexo =  "F" then 0 end) as F, count(case when sexo = "M"  then 0 end) as M '))
       ->where('opm_id','=' ,$opmt)
       ->get();
    }


   }
