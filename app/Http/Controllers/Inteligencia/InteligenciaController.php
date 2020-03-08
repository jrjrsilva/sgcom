<?php

namespace sgcom\Http\Controllers\Inteligencia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Storage;
use sgcom\Http\Controllers\Controller;
use sgcom\Models\Aisp;
use sgcom\Models\Criminoso;
use sgcom\Models\Faccao;
use sgcom\Models\GaleriaCriminoso;
use sgcom\Models\HistoricoCrimiProcessual;
use sgcom\Models\PosicaoFaccao;
use sgcom\Models\SituacaoProcessual;
use File;
use sgcom\Models\Cpr;
use sgcom\Models\Opm;

class InteligenciaController extends Controller
{
  private $totalPage = 10;

  private $criminoso;

    public function index()
    {
      $this->dadosGerais();

      $criminosos = Criminoso::paginate($this->totalPage);
      
      return view('inteligencia.criminosos',compact('criminosos'));
    }

    public function excluir($id)
    {
      $this->dadosGerais();
      $criminoso = Criminoso::findOrFail($id);
      $criminoso->delete();
      $criminosos = Criminoso::paginate($this->totalPage);

      return view('inteligencia.criminosos',compact('criminosos'));
    }

    public function excluirHist($id)
    {
      $this->dadosGerais();
      $historico = HistoricoCrimiProcessual::findOrFail($id);
      $historico->delete();
      $criminoso = Criminoso::findOrFail($historico->criminoso_id);

      return view('inteligencia.form',compact('criminoso'));
    }

    public function exHist(Request $request)
    {
     // dd($request->all());

      $this->dadosGerais();
      $historico = HistoricoCrimiProcessual::findOrFail($request->id_excluir);

      $historico->delete();
      $criminoso = Criminoso::findOrFail($historico->criminoso_id);

     // return view('inteligencia.form',compact('criminoso'));
      return redirect()->back()->with('success', 'Atualizado com sucesso!');
    }

    public function edit($id)
    {
      $this->dadosGerais();
      $criminoso = Criminoso::findOrFail($id);
     return view('inteligencia.form',compact('criminoso'));
    }

    public function form()
    {
      $this->dadosGerais();

      $criminoso =  new Criminoso();

      return view('inteligencia.form',compact('criminoso'));
    }

    public function dadosGerais()
    {
      $usr = Auth::user();
      $opmt = $usr->efetivo->opm_id;
      $cprId = $usr->efetivo->opm->cpr_id;
      $aisps = Aisp::orderBy('descricao', 'asc')->get();
      $faccoes = Faccao::orderBy('descricao', 'asc')->get();
      $posicoes = PosicaoFaccao::orderBy('descricao', 'asc')->get();
      $situacoes = SituacaoProcessual::orderBy('descricao', 'asc')->get();
      $cprs = Cpr::whereIn('id',[12])->get();

      if($usr->existePapel('Gestor CPR')){
        $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=',$cprId)->get();
      }else if($usr->existePapel('Admin')){
        $opms = Opm::orderBy('opm_sigla', 'asc')->get();
      }else {
        $opms = Opm::orderBy('opm_sigla', 'asc')->where('id', '=',$opmt)->get();
      }

      return view()->share(compact('aisps','faccoes','posicoes','situacoes','opms','cprs'));
    }

    public function buscarStatusProcessual($id)
    {

      $status =  DB::table('status_processual')
      ->where('situacao_processual_id', $id)
      ->get(['id', 'nome']);

       return response()->json($status);

    }

    public function salvarCriminoso(Request $request){
       // dd($request->all());
       try{
         $criminoso = new Criminoso();
          if($request->id != null)
              $criminoso = Criminoso::findOrFail($request->id);
              
              $user = Auth()->user();
              $criminoso->opm_id = $user->efetivo->opm->id;
              $criminoso->user_id = $user->id;
              
            $criminoso->nome = $request->nome;
            $criminoso->sexo = $request->sexo;
            $criminoso->apelido = $request->apelido;
            $criminoso->rg = $request->rg;
            $criminoso->cpf = $request->cpf;
            $criminoso->faccao_id = $request->faccao;
            $criminoso->posicao_faccao_id = $request->posicao;
            $criminoso->naturalidade = $request->naturalidade;
            $criminoso->endereco = $request->endereco;
            $criminoso->bairro = $request->bairro;
            $criminoso->area_atuacao = $request->area_atuacao;
            $criminoso->aisp_id = $request->aisp;
            $criminoso->barralho_crime = $request->barralho;

            if($request->hasfile('arquivo') && $request->file('arquivo')->isvalid()){
              $extension = $request->arquivo->extension();
              $name = uniqid(date('HisYmd'));
              $nameFile = "{$name}.{$extension}";
              
              $path  =  $request->file('arquivo')->move('fotos_criminosos',$nameFile);
              $criminoso->foto =  $path;
              }
          

        $criminoso->save();

        return redirect()->back()->with('success', 'Atualizado com sucesso!');

      } catch (\Exception $e) {
        $errors = $e->getMessage();
        return redirect()->back()->withErrors('errors')->withInput();
      }
    }
    

    public function salvarProcessualCriminoso(Request $request){
 // dd($request->all());
        $this->dadosGerais();
      try{
       $criminoso = Criminoso::findOrFail($request->criminoso_id);
        
      $historico = new HistoricoCrimiProcessual(); 
        $historico->situacao_processual_id = $request->situacao_processual;
        $historico->status_processual_id = $request->status_processual;
        $historico->enquadramento = $request->enquadramento;
        $historico->criminoso_id = $request->criminoso_id;
        $historico->data_registro = now();
        $historico->unidade_prisional = $request->unidade_prisional;
        $historico->user_id = Auth()->user()->id;
//dd($historico);
        $historico->save();
        return view('inteligencia.form',compact('criminoso'));
      // return redirect()->back()->with('success', 'Atualizado com sucesso!');

     } catch (\Exception $e) {
       $errors = $e->getMessage();
       return redirect()->back()->withErrors('errors')->withInput();
     } 
   }

   public function salvarAlbumCriminoso(Request $request){
   // dd($request->all());
    try{
      $file = new GaleriaCriminoso();
       
           $file->criminoso_id = $request->crimi_id;
         
           $file->descricao = $request->descricao_img;
         
         if($request->hasfile('arquivo1') && $request->file('arquivo1')->isvalid()){
           $extension = $request->arquivo1->extension();
           $name = uniqid(date('HisYmd'));
           $nameFile = "{$name}.{$extension}";
           
           $path  =  $request->file('arquivo1')->move('fotos_criminosos',$nameFile);

           $file->foto =  $path;

           } 
       

     $file->save();

     return redirect()->back()->with('success', 'Atualizado com sucesso!');

   } catch (\Exception $e) {
     $errors = $e->getMessage();
     return redirect()->back()->withErrors('errors')->withInput();
   }
 }

 public function deleteAlbumCriminoso($id)
 {
   $galeria = GaleriaCriminoso::findorFail($id);
   if(isset($galeria)){
     $arquivo = $galeria->foto;
     $path = public_path().'/';
     File::delete($path.$arquivo);
     $galeria->delete();
   }
 return redirect()->back()->with('success', 'Removido com sucesso!');
 }

 public function downloadAlbumCriminoso($id)
 {
   $galeria = GaleriaCriminoso::findorFail($id);
   if(isset($galeria)){
     $path = public_path().'/';
      return response()->download($path.$galeria->foto);
   }
  return redirect()->back()->with('success', 'Sucesso!');
 }


 public function search(Request $request, Criminoso $criminoso)
 {
   $this->dadosGerais();
   $dataForm = $request->except('_token');

   $criminosos =  $criminoso->search($dataForm, $this->totalPage);

   return view('inteligencia.criminosos',compact('criminosos','dataForm'));
 }

}
