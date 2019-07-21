<?php

namespace sgcom\Http\Controllers\ServicoOperacional;

use Illuminate\Http\Request;
use sgcom\Http\Controllers\Controller;
use sgcom\Models\Opm;


class OcorrenciaController extends Controller
{
    private $totalPage = 15;

    public function __construct() {
      //$opms = Opm::orderBy('opm_sigla', 'asc')->get();
      $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=','12')->get();
      
      view()->share(compact('opms'));
    }
 
 
    public function index()
    {
      //  dd( auth()->user());

      // dd(BD::Opm::class)
    

        return view('servicooperacional.ocorrencia.index');
    }

}
