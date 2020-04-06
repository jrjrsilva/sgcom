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
use sgcom\Models\DocumentosCriminoso;
use sgcom\Models\ModusOperandi;
use sgcom\Models\Opm;
use sgcom\Models\TipoAtuacaoCriminoso;

class InteligenciaController extends Controller
{
  private $totalPage = 10;

  private $criminoso;

    public function index()
    {
      $this->dadosGerais();

       $usr = Auth::user();
      $criminosos = Criminoso::where('opm_id','=',$usr->efetivo->opm_id)
      ->orderBy('nome')
      ->paginate($this->totalPage);
      
      return view('inteligencia.criminosos',compact('criminosos'));
    }

    public function excluir($id)
    {
      $this->dadosGerais();
      $criminoso = Criminoso::findOrFail($id);
      $criminoso->delete();
      $criminosos = Criminoso::paginate($this->totalPage)->orderBy('nome');

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
      $modusoperandis = ModusOperandi::orderBy('nome')->get();
      $tipoatuacoes = TipoAtuacaoCriminoso::orderBy('nome')->get();

      if($usr->existePapel('Gestor CPR')){
        $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=',$cprId)->get();
      }else if($usr->existePapel('Admin')){
        $opms = Opm::orderBy('opm_sigla', 'asc')->get();
      }else {
        $opms = Opm::orderBy('opm_sigla', 'asc')->where('id', '=',$opmt)->get();
      }

      return view()->share(compact('aisps','faccoes','posicoes','situacoes','opms','cprs','modusoperandis','tipoatuacoes'));
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

       $mensagens = [
        'required' => ':attribute &eacute; obrigat&oacute;rio!',
        'foto.mimes' => 'Tipo não permitido!',
        'foto.max'   => 'A foto deve ter no máxmo 2MB'
        ];

      $this->validate($request,
      [
        'area_atuacao'  => 'required',
        'foto'          => 'mimes:jpeg,jpg,png|max:2048',
      ],$mensagens);

       try{
         $criminoso = new Criminoso();
          if($request->id != null)
              $criminoso = Criminoso::findOrFail($request->id);
              
              $user = Auth()->user();
              $criminoso->opm_id = $user->efetivo->opm->id;
              $criminoso->user_id = $user->id;
              
            $criminoso->nome = trim(mb_strtoupper($request->nome,'UTF-8'));
            $criminoso->sexo = $request->sexo;
            $criminoso->apelido = trim(mb_strtoupper($request->apelido,'UTF-8'));
            $criminoso->rg = $request->rg;
            $criminoso->cpf = $request->cpf;
            $criminoso->faccao_id = $request->faccao;
            $criminoso->posicao_faccao_id = $request->posicao;
            $criminoso->naturalidade = trim(mb_strtoupper($request->naturalidade,'UTF-8'));
            $criminoso->endereco = trim(mb_strtoupper($request->endereco,'UTF-8'));
            $criminoso->bairro = trim(mb_strtoupper($request->bairro,'UTF-8'));
            $criminoso->area_atuacao = trim(mb_strtoupper($request->area_atuacao,'UTF-8'));
            $criminoso->aisp_id = $request->aisp;
            $criminoso->barralho_crime = $request->barralho;
            $criminoso->nome_mae = trim(mb_strtoupper($request->nome_mae,'UTF-8'));
            $criminoso->data_nascimento = $request->data_nascimento;
            $criminoso->tipo_atuacao_criminoso_id = $request->tipoatuacao;
            $criminoso->modus_operandi_id = $request->modusoperandi;

            if($request->hasfile('foto') && $request->file('foto')->isvalid()){
              $extension = $request->arquivo->extension();
              $name = uniqid(date('HisYmd'));
              $nameFile = "{$name}.{$extension}";
              
              $path  =  $request->file('foto')->move('fotos_criminosos',$nameFile);
              $criminoso->foto =  $path;
              }
          

        $criminoso->save();

        if($request->id == null){
          return redirect()
          ->route('inteligencia.form')
          ->with('success', 'Atualizado com sucesso!');  
        }else{
        return redirect()
        ->route('inteligencia.crim.edit',$request->id)
        ->with('success', 'Atualizado com sucesso!');
        }
      } catch (\Exception $e) {
       // $errors = $e->getMessage();
        return redirect()->back()->with('erro!','Formato não permitido de imagem');
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
    $messages = [
      'required'              => ':attribute &eacute; obrigat&oacute;rio!',
      'foto_da_galeria.mimes' => 'Tipo não permitido!',
      'foto_da_galeria.max'   => 'A foto deve ter no máxmo 2MB'
      ];

    $this->validate($request,
    [
      'descricao_img'     => 'required|min:5',    
      'foto_da_galeria'   => 'required|mimes:jpeg,jpg,png|max:2048',
    ],$messages);

    try{
      $file = new GaleriaCriminoso();
       
           $file->criminoso_id = $request->crimi_id;
         
           $file->descricao = $request->descricao_img;
          
         if($request->hasfile('foto_da_galeria') && $request->file('foto_da_galeria')->isvalid()){
          $extension = $request->foto_da_galeria->extension();
         // $tamanho = filesize($request->foto_da_galeria);
         
         
        /*    for($i=0;$i<=count($tipos);$i++)
          {  
          if($tamanho <= $limite)
          { */
            $name = uniqid(date('HisYmd'));
            $nameFile = "{$name}.{$extension}";
            
            $path  =  $request->file('foto_da_galeria')->move('fotos_criminosos',$nameFile);
 
            $file->foto =  $path;

            $file->save();

            return $this->edit($request->crimi_id);
          /* }
          } */
      } 
   
   } catch (\Exception $e) {
     $e->getMessage();
     return redirect() 
     ->route('inteligencia.crim.edit',$request->crimi_id)->withInput();
   }
 }

 public function deleteAlbumCriminoso(Request $request)
 {
   $galeria = GaleriaCriminoso::findorFail($request->galeria_id);
   if(isset($galeria)){
     $arquivo = $galeria->foto;
     $path = public_path().'/';
     File::delete($path.$arquivo);
     $galeria->delete();
   }
  return redirect() 
 ->route('inteligencia.crim.edit',$galeria->criminoso_id);
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

 public function salvarDocCriminoso(Request $request){
  // dd($request->all());
   try{
     $tipos = ['pdf'];
    
     $file = new DocumentosCriminoso();
      
          $file->criminoso_id = $request->crimi_id;
        
          $file->descricao = $request->descricao_doc;
        
        if($request->hasfile('arquivo2') && $request->file('arquivo2')->isvalid()){
         $extension = $request->arquivo2->extension();
         $tamanho = $request->arquivo2->size();
         $limite = 2048;
          
         for($i=0;$i<=count($tipos);$i++)
         { 
         if($tipos[$i] == $extension && $tamanho <= $limite)
         {
           $name = uniqid(date('HisYmd'));
           $nameFile = "{$name}.{$extension}";
           
           $path  =  $request->file('arquivo2')->move('docs_criminosos',$nameFile);

           $file->foto =  $path;

           $file->save();

           return $this->edit($request->crimi_id);
         }
         }
     } 
  
  } catch (\Exception $e) {
    $e->getMessage();
    return redirect() 
    ->route('inteligencia.crim.edit',$request->crimi_id)
    ->with('errors','Formato/Tamanho não permitido!');
  }
}

public function deleteDocCriminoso($id)
{
  $doc = DocumentosCriminoso::findorFail($id);
  if(isset($doc)){
    $arquivo = $doc->documento;
    $path = public_path().'/';
    File::delete($path.$arquivo);
    $doc->delete();
  }
return  $this->edit($doc->criminoso_id);

}


 public function search(Request $request, Criminoso $criminoso)
 {
   $this->dadosGerais();
   $dataForm = $request->except('_token');

   $criminosos =  $criminoso->search($dataForm, $this->totalPage)->orderBy('nome');

   return view('inteligencia.criminosos',compact('criminosos','dataForm'));
 }

}
