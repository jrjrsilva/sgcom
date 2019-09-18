<?php

namespace sgcom\Http\Controllers\Frotas;

use Illuminate\Support\Facades\DB;
use sgcom\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use sgcom\Models\Opm;
use sgcom\Models\Aisp;
use sgcom\Models\Delegacia;
use sgcom\Models\TipoOcorrencia;
use sgcom\Models\Ocorrencia;
use sgcom\Models\Envolvido;
use sgcom\Models\Droga;
use sgcom\Models\File;
use sgcom\Models\MarcaVeiculo;
use sgcom\Models\ModeloVeiculo;
use Illuminate\Http\Request;

class FrotaController extends Controller
{

  private $totalPage = 15;

  private $ocorrencia;

  public function __construct() {
    $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=','12')->get();
    $aisps = Aisp::orderBy('descricao', 'asc')->get();
    $delegacias = Delegacia::orderBy('descricao', 'asc')->get();
    $tiposocorrencias = TipoOcorrencia::orderBy('descricao', 'asc')->get();
    $marcaveiculos = MarcaVeiculo::orderBy('descricao', 'asc')->get();
    $modeloveiculos = ModeloVeiculo::orderBy('descricao', 'asc')->get();
    
    view()->share(compact('opms','aisps','delegacias','tiposocorrencias','marcaveiculos','modeloveiculos'));
  }
  
  public function index()
    {
      return view('frota.index');
    }

  public function lista()
    {
      return view('frota.lista');
    }

  public function salvar(Request $request)
  {
    $placa= strtoupper($request->placa);
    dd($placa);
  }

 
}

    
