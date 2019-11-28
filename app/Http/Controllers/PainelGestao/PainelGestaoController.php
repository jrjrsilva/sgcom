<?php

namespace sgcom\Http\Controllers\PainelGestao;


use Illuminate\Http\Request;
use sgcom\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use sgcom\Models\Opm;
use sgcom\Models\Efetivo;
use sgcom\Models\Viatura;
use sgcom\Models\GrauHierarquico;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use sgcom\Service\EfetivoService;


class PainelGestaoController extends Controller
{
   
    private $totalPage = 20;
    private $efetivoService;
    


    public function __construct() {
         $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=','12')->get();
         $ghs = GrauHierarquico::orderBy('precedencia','asc')->get();
         $this->efetivoService = new EfetivoService();

         view()->share(compact('opms','ghs'));
    }
 

    public function index()
    {
        
      $this->dadosGerais();

       $opm = Auth::user()->efetivo->opm_id;
     
       $efetivos = Efetivo::where('opm_id',$opm)
       ->orderBy('grauhierarquico_id', 'DESC')
       ->paginate($this->totalPage);
     
         return view('painelgestao.index',compact('efetivos'));
        
    }

    public function dadosGerais()
    {
      $usr = Auth::user();
      $opmt = $usr->efetivo->opm_id;
      $cprt = $usr->efetivo->opm->cpr_id;
      $opmTotal = $this->getEfetivoTotalOpm($opmt);
      $cprTotal = $this->getEfetivoTotalCpr($cprt);
      $viaturas = Viatura::orderBy('prefixo')
      ->where('opm_id',$opmt)
      ->paginate($this->totalPage);
      $homicidioCpr = DB::table('ocorrencia')
      ->where('tipoocorrencia_id', 1)
      ->count();

        $homicidioOpm = DB::table('ocorrencia')
        ->where('tipoocorrencia_id', 1)
        ->where('opm_id',$opmt)
        ->count();
       
        if($homicidioCpr > 0)
              $phomicidioOpm = ($homicidioOpm * 100)/$homicidioCpr;
           else 
          $phomicidioOpm = 0;

        $vlhom_cpr = '['.$homicidioCpr.']';
        $vlhom_opm = '['.$homicidioOpm.']';

        $aniversarios = $this->efetivoService->getAniversarioHojeCpr($cprt);
        $aniversariosA = $this->efetivoService->getAniversarioAmanhaCpr($cprt);
        $aniversariosD = $this->efetivoService->getAniversarioDepoisCpr($cprt);

     return view()->share(compact('aniversarios','aniversariosA','aniversariosD','viaturas','vlhom_opm','vlhom_cpr','opmTotal','cprTotal','homicidioCpr','homicidioOpm','phomicidioOpm'));
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
     $aniversarios = Efetivo::where('datanascimento','=',day(now))->get();
   }

}
