<?php

namespace sgcom\Http\Controllers\Inteligencia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use sgcom\Http\Controllers\Controller;
use sgcom\Models\Aisp;
use sgcom\Models\Criminoso;
use sgcom\Models\Faccao;
use sgcom\Models\HistoricoCrimiProcessual;
use sgcom\Models\PosicaoFaccao;
use sgcom\Models\SituacaoProcessual;

class InteligenciaController extends Controller
{
  private $totalPage = 15;

  private $criminoso;

    public function index()
    {
      $criminosos = Criminoso::paginate($this->totalPage);

      return view('inteligencia.index',compact('criminosos'));
    }

    public function excluir($id)
    {
      $this->dadosGerais();
      $criminoso = Criminoso::findOrFail($id);
      $criminoso->delete();
      $criminosos = Criminoso::paginate($this->totalPage);

      return view('inteligencia.index',compact('criminosos'));
    }

    public function excluirHist($id)
    {
      $this->dadosGerais();
      $historico = HistoricoCrimiProcessual::findOrFail($id);
      $historico->delete();
      $criminoso = Criminoso::findOrFail($historico->criminoso_id);

      return view('inteligencia.form',compact('criminoso'));
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
      return view('inteligencia.form');
    }

    public function dadosGerais()
    {
      $aisps = Aisp::orderBy('descricao', 'asc')->get();
      $faccoes = Faccao::orderBy('descricao', 'asc')->get();
      $posicoes = PosicaoFaccao::orderBy('descricao', 'asc')->get();
      $situacoes = SituacaoProcessual::orderBy('descricao', 'asc')->get();
      return view()->share(compact('aisps','faccoes','posicoes','situacoes'));
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
              
            $criminoso->nome = $request->nome;
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

        $historico->save();

       return redirect()->back()->with('success', 'Atualizado com sucesso!');

     } catch (\Exception $e) {
       $errors = $e->getMessage();
       return redirect()->back()->withErrors('errors')->withInput();
     } 
   }
}
