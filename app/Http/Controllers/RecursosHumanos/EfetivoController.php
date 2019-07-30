<?php

namespace sgcom\Http\Controllers\RecursosHumanos;

use Illuminate\Http\Request;
use sgcom\Http\Controllers\Controller;
use sgcom\Models\Opm;
use sgcom\Models\Efetivo;

class EfetivoController extends Controller
{
    private $totalPage = 100;

    public function __construct() {
      //$opms = Opm::orderBy('opm_sigla', 'asc')->get();
      $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=','12')->get();
      
      view()->share(compact('opms'));
    }
 
 
    public function index()
    {
      //  dd( auth()->user());

      // dd(BD::Opm::class)
      $efetivos = Efetivo::paginate($this->totalPage);

        return view('recursoshumanos.efetivo',compact('efetivos'));
    }

    public function searchMatricula(Request $request, Efetivo $efetivo)
    {
      // dd($request->all());
      $dataForm = $request->except('_token');
 
      $efetivos =  $efetivo->searchUnique($dataForm, $this->totalPage);
 
      return view('recursoshumanos.efetivo',compact('efetivos','dataForm'));
    }
}
