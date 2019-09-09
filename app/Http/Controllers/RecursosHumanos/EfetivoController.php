<?php

namespace sgcom\Http\Controllers\RecursosHumanos;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use sgcom\Http\Controllers\Controller;
use sgcom\Models\Opm;
use sgcom\Models\Efetivo;
use sgcom\Models\GrauHierarquico;

class EfetivoController extends Controller
{
  
    private $totalPage = 100;

    public function __construct() {
      $opms = Opm::orderBy('opm_sigla', 'asc')->get();
      //$opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=','12')->get();
      $ghs = GrauHierarquico::orderBy('precedencia','asc')->get();

      view()->share(compact('opms','ghs'));
    }
 


    public function index()
    {
      //  dd( auth()->user());

   /*   $efetivos = Efetivo::join('grauhierarquico','pmgeral.grauhierarquico_id','=','grauhierarquico.id')
                          ->orderBy('grauHierarquico.precedencia','asc')->paginate($this->totalPage);*/
        $efetivos = Efetivo::where('opm_id','999')->paginate($this->totalPage);
      
        return view('recursoshumanos.listageral',compact('efetivos'));
    }

    public function searchMatricula(Request $request, Efetivo $efetivo)
    {
      // dd($request->all());
      $dataForm = $request->except('_token');
 
      $efetivos =  $efetivo->searchUnique($dataForm, $this->totalPage);
     // dd($efetivos);

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

      if($request->id != null)
        $efetivo = Efetivo::find($request->id);

        //$efetivo->id = $request->id;
        $efetivo->nome = $request->nome;
        $efetivo->dataadmissao = $request->data_admissao;
        $efetivo->datanascimento = $request->data_nascimento;
        $efetivo->opm_id = $request->opm;
        $efetivo->grauhierarquico_id = $request->gh;
        $efetivo->fatorrh = $request->fatorrh;
        $efetivo->tiposangue = $request->tiposangue;
        $efetivo->matricula = $request->matricula;
        $efetivo->sexo = $request->sexo;


        $efetivo->save();

        //return redirect()->back()->withErrors('Erros')->withInput();
        return redirect()->back()->with('success', 'Atualizado com sucesso!');


    }
}
