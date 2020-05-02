<?php

namespace sgcom\Http\Controllers\Armamento;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use sgcom\Http\Controllers\Controller;
use sgcom\Models\Opm;
use sgcom\Models\Arma;
use sgcom\Models\Calibre;
use sgcom\Models\EspecieArma;
use sgcom\Models\MarcaArma;
use sgcom\Models\ModeloArma;
use sgcom\Models\SituacaoArma;

class ArmamentoController extends Controller
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

    $armasTotalOPM = Arma::where('opm_id', $usr->efetivo->opm_id)
      ->count();

    $armasManutencao = Arma::where('opm_id', $usr->efetivo->opm_id)
      ->where('situacao', 1)
      ->count();

    $armasCargaPessoal = Arma::where('opm_id', $usr->efetivo->opm_id)
      ->where('situacao', 13)
      ->count();

    $armasPericiaIcap = Arma::where('opm_id', $usr->efetivo->opm_id)
      ->where('situacao', 5)
      ->count();
    if ($usr->existePapel('Gestor CPR')) {
      $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=', $cprId)->get();
    } else if ($usr->existePapel('Admin')) {
      $opms = Opm::orderBy('opm_sigla', 'asc')->get();
    } else {
      $opms = Opm::orderBy('opm_sigla', 'asc')->where('id', '=', $opmt)->get();
    }

    $calibres = Calibre::all();
    $especies = EspecieArma::all();
    $situacaoarmas = SituacaoArma::orderBy('nome')->get();
    $marcaarmas = MarcaArma::all();
    $modeloarmas = ModeloArma::all();

    view()->share(compact('armasTotalOPM', 'armasManutencao', 'armasCargaPessoal', 'armasPericiaIcap', 'opms', 'calibres', 'especies', 'situacaoarmas', 'modeloarmas', 'marcaarmas'));
  }

  public function lista()
  {
    $usr = Auth()->user();
    $this->dadosGerais();



    $armas = Arma::where('opm_id', $usr->efetivo->opm_id)
      ->orderBy('numero_de_serie')
      ->paginate($this->totalPage);

    //$armas = Arma::whereIn('opm_id',$opms)->orderBy('numero_de_serie')->paginate($this->totalPage);
    /*  DB::table('arma')
     ->select('*')
     ->whereIn('opm_id',$opms)
     ->paginate($this->totalPage); */

    return view('armas.lista', compact('armas'));
  }

  public function index(Arma $arma)
  {
    return view('armas.index', compact('arma'));
  }


  public function salvar(Request $request)
  {

    $arma = new arma();

    if ($request->id != null)
      $arma = Arma::find($request->id);

    $arma->opm_id  = $request->opm;
    $arma->situacao = $request->situacaoarma;

    $retorno =  $arma->save();

    if ($retorno)
      return redirect()->route('armas.lista')->with('success', 'arma atualizada');

    return redirect()->back()->with('error', 'Falha ao atualizar!');
  }

  public function edit($id)
  {

    $this->dadosGerais();
    $arma = Arma::find($id);
    if (!$arma) {
      abort(404);
    }

    return view('armas.index', compact('arma'));
  }

  public function search(Request $request, Arma $arma)
  {
    // dd($request->all());
    $dataForm = $request->except('_token');

    $armas =  $arma->search($dataForm, $this->totalPage);

    $this->dadosGerais();

    return view('armas.lista', compact('armas', 'dataForm'));
  }
}
