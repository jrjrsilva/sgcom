<?php

namespace sgcom\Service;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use sgcom\Models\Cep;
use sgcom\Models\Efetivo;
use sgcom\Models\Opm;

class EfetivoService
{
    use Notifiable;
    private $totalPage = 20;

    public function __construct() {
     /*  $usr = Auth::user();
      $opmt = $usr->efetivo->opm_id;
      $cprt = $usr->efetivo->opm->cpr_id; */
    }

    public function getCep($cep)
    {
      $endereco = DB::table('cep')
      ->where('cep','=',$cep)
      ->get();
      return $endereco;
    }
   
    public function getAniversarioMes($cprt)
    {
     $aniversariosHoje = DB::table('pmgeral')
     ->join('opm', 'pmgeral.opm_id','=','opm.id')
     ->join('grauhierarquico', 'pmgeral.grauhierarquico_id','=','grauhierarquico.id')
     ->where('opm.cpr_id','=' ,$cprt)
     ->whereMonth('datanascimento','=',date('m'))
     ->select('nome', 'opm.opm_sigla','datanascimento','grauhierarquico.sigla')
     ->orderBy('grauhierarquico_id','desc')
     ->paginate($this->totalPage);
     // dd($aniversariosHoje);
     return $aniversariosHoje;
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

    public function getAniversarioHojeCpr($cprt)
    {
     $aniversariosHoje = DB::table('pmgeral')
     ->join('opm', 'pmgeral.opm_id','=','opm.id')
     ->join('grauhierarquico', 'pmgeral.grauhierarquico_id','=','grauhierarquico.id')
     ->where('opm.cpr_id','=' ,$cprt)
     ->whereMonth('datanascimento','=',date('m'))
     ->whereDay('datanascimento','=',date('d'))
     ->select('nome', 'opm.opm_sigla','datanascimento','grauhierarquico.sigla')
     ->orderBy('grauhierarquico_id','desc')
     ->paginate($this->totalPage);
     // dd($aniversariosHoje);
     return $aniversariosHoje;
    }

    public function getAniversarioAmanhaCpr($cprt)
    {
    return $aniversariosAmanha = DB::table('pmgeral')
     ->join('opm', 'pmgeral.opm_id','=','opm.id')
     ->join('grauhierarquico', 'pmgeral.grauhierarquico_id','=','grauhierarquico.id')
     ->where('opm.cpr_id','=' ,$cprt)
     ->whereMonth('datanascimento','=',date('m'))
     ->whereDay('datanascimento','=',date('d')+1)
     ->select('nome', 'opm.opm_sigla','datanascimento','grauhierarquico.sigla')
     ->orderBy('grauhierarquico_id','desc')
     ->paginate($this->totalPage);;
    }

    public function getAniversarioDepoisCpr($cprt)
    {
    return $aniversariosDepois = DB::table('pmgeral')
     ->join('opm', 'pmgeral.opm_id','=','opm.id')
     ->join('grauhierarquico', 'pmgeral.grauhierarquico_id','=','grauhierarquico.id')
     ->where('opm.cpr_id','=' ,$cprt)
     ->whereMonth('datanascimento','=',date('m'))
     ->whereDay('datanascimento','=',date('d')+2)
     ->select('nome', 'opm.opm_sigla','datanascimento','grauhierarquico.sigla')
     ->orderBy('grauhierarquico_id','desc')
     ->paginate($this->totalPage);;
    }

}
