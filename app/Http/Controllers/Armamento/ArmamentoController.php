<?php

namespace sgcom\Http\Controllers\Armamento;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
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

    public function __construct() {
      $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=','12')->get();
      $calibres = Calibre::all();
      $especies = EspecieArma::all();
      $situacaoarmas = SituacaoArma::all();
      $marcaarmas = MarcaArma::all();
      $modeloarmas = ModeloArma::all();
     
      view()->share(compact('opms','calibres','especies','situacaoarmas','modeloarmas','marcaarmas'));
    }
    
    public function lista()
    {
      $opms = DB::table('opm')->select('id')->where('cpr_id', '=','12')->pluck('id')->toArray();
    
      $armas = 
      Arma::whereIn('opm_id',$opms)->orderBy('numero_de_serie')->paginate($this->totalPage);
    /*  DB::table('arma')
     ->select('*')
     ->whereIn('opm_id',$opms)
     ->paginate($this->totalPage); */
      return view('armas.lista',compact('armas'));
    }
  
    public function index(Arma $arma)
      {
        return view('armas.index',compact('arma'));
      }
  

    public function salvar(Request $request)
    {  
  
      $arma = new arma();
  
        if($request->id != null)
          $arma = Arma::find($request->id);
          $arma->opm_id  = $request->opm;
          
            $retorno =  $arma->save();

            if($retorno)
            return redirect()->route('armas.lista')->with('success','arma atualizada');

            return redirect()->back()->with('error', 'Falha ao atualizar!');
            
    }

    public function edit($id)
    {
      $arma = Arma::find($id);
      if(!$arma){
        abort(404);
      }
      
      return view('armas.index', compact('arma'));
     
    }

    public function search(Request $request, Arma $arma)
    {
      // dd($request->all());
      $dataForm = $request->except('_token');
 
      $armas =  $arma->search($dataForm, $this->totalPage);
     // dd($efetivos);

      return view('armas.lista',compact('armas','dataForm'));
    }
}
