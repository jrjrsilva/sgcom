<?php

namespace sgcom\Http\Controllers\ServicoOperacional;

use Illuminate\Http\Request;
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

class OcorrenciaController extends Controller
{
    private $totalPage = 15;

    private $ocorrencia;

    public function __construct() {
      $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=','12')->get();
      $aisps = Aisp::orderBy('descricao', 'asc')->get();
      $delegacias = Delegacia::orderBy('descricao', 'asc')->get();
      $tiposocorrencias = TipoOcorrencia::orderBy('descricao', 'asc')->get();
      
      view()->share(compact('opms','aisps','delegacias','tiposocorrencias'));
    }
 
 
    public function index(Ocorrencia $ocorrencia)
    {
      $this->ocorrencia = $ocorrencia;
      $envolvidos       = $this->ocorrencia->envolvidos;
      $drogas           = $this->ocorrencia->drogas;
      return  view('servicooperacional.ocorrencia.index',compact('envolvidos','ocorrencia','drogas'));
    }

    public function dashboard()
    {
      $ocorrencias = Ocorrencia::orderBy('data', 'desc')->get();
      return view('servicooperacional.ocorrencia.dashboard',compact('ocorrencias'));
    }

   /* public function addEnvolvido(Request $request, Ocorrencia $ocorrencia)
    {
      // dd($request->all());
      $dataForm = $request->except('_token');
      $envolvidos = $ocorrencia->envolvidos;
      $envolvidos.push($dataForm);
 
      return view('recursoshumanos.efetivo',compact('efetivos','dataForm'));
    }
    */
    
    public function salvar(Request $request)
    {
     //dd($request->all());
   
      $ocorrencia = new Ocorrencia();

      if($request->id != null)
        $ocorrencia = Ocorrencia::find($request->id);
     
      $ocorrencia->opm_id               = $request->opm;
      $ocorrencia->data                 = $request->data_ocorre;
      $ocorrencia->hora                 = $request->hora_ocorre;
      $ocorrencia->tipoocorrencia_id    = $request->tipo_ocorr;
      $ocorrencia->ocorrencia_local     = $request->local_ocorre;
      $ocorrencia->ocorrencia_relatorio = $request->input('desc_ocorrencia');

      $ocorrencia->delegacia_id         = $request->delegacia;
      $ocorrencia->end_delegacia        = $request->end_delegacia;
      $ocorrencia->aisp_id              = $request->aisp;
      $ocorrencia->nome_delegado        = $request->delegado;
      $ocorrencia->num_inquerito        = $request->inq_policial;
      $ocorrencia->num_boletim          = $request->bo;
      $ocorrencia->veiculos_recuperados = $request->prod_veiculos;
      $ocorrencia->armas_apreendidas    = $request->prod_armas_fogo;
      $ocorrencia->armas_brancas        = $request->prod_armas_branca;
      $ocorrencia->armas_artesanais     = $request->prod_armas_artesanais;
      $ocorrencia->flagrantes           = $request->prod_flagrantes;
      $ocorrencia->tco                  = $request->prod_tcos;
      $ocorrencia->menores_apreendidos  = $request->prod_menores_apreend;
    
      if(Auth::check()){
        $ocorrencia->user_id              = Auth::user()->id;
      }

      $ocorrencia->save();


      $envolvido  = $request->envolvido;
      $idade      = $request->idade;
      $tipo       = $request->tipo_envolvimento;
      $sexo       = $request->sexo;
      $rg         = $request->rg;


      if(is_array($tipo)){
          $keys = array_keys($tipo);

          $size = count($tipo);
 
      for ($i = 0; $i < $size; $i++) {
          $key   = $keys[$i];

          $objEnv = new Envolvido();
          $objEnv->nome           = $envolvido[$key];
          $objEnv->idade          = $idade[$key];
          $objEnv->tipo_envol     = $tipo[$key];
          $objEnv->sexo           = $sexo[$key];
          $objEnv->rg             = $rg[$key];
          $objEnv->ocorrencia_id  = $ocorrencia->id;
          if($tipo[$key] != null){
            $objEnv->save();
          }
           
        }
      } 

          $tipo_droga   = $request->tipo_droga;
          $desc_droga   = $request->desc_outras_drogas;
          $qtd_droga    = $request->qtd_drogas;

          if(is_array($tipo_droga)){
            $keys = array_keys($tipo_droga);

            $size = count($tipo_droga);
 
            for ($i = 0; $i < $size; $i++) {
              $key   = $keys[$i];

              $objDroga = new Droga();
              $objDroga->tipo_droga                 = $tipo_droga[$key];
              $objDroga->descricao_droga            = $desc_droga[$key];
              $objDroga->quantidade_droga           = $qtd_droga[$key];
              $objDroga->ocorrencia_id              = $ocorrencia->id;
              if($tipo_droga[$key] != null)
                $objDroga->save(); 
            }     

        }

      return $this->dashboard();//view('servicooperacional.ocorrencia.index', compact('envolvidos','ocorrencia'));

    }

    public function edit($id)
    {
      $ocorrencia = Ocorrencia::find($id);
      if(!$ocorrencia){
        abort(404);
      }
      $envolvidos = $ocorrencia->envolvidos;
      $drogas = $ocorrencia->drogas;
      return view('servicooperacional.ocorrencia.index', compact('ocorrencia','envolvidos','drogas'));
     
    }

    public function excluirenv($id)
    {
      $envolvido = Envolvido::find($id);
      if(!$envolvido){
        abort(404);
      }
      $envolvido->delete();
      $ocorrencia = Ocorrencia::find($envolvido->ocorrencia_id);
      $envolvidos = $ocorrencia->envolvidos;
      $drogas = $ocorrencia->drogas;
      return view('servicooperacional.ocorrencia.index', compact('ocorrencia','envolvidos','drogas'));
     
    }

    public function excluirdroga($id)
    {
      $droga = Droga::find($id);
      if(!$droga){
        abort(404);
      }
      $droga->delete();
      $ocorrencia = Ocorrencia::find($droga->ocorrencia_id);
      $envolvidos = $ocorrencia->envolvidos;
      $drogas = $ocorrencia->drogas;
      return view('servicooperacional.ocorrencia.index', compact('ocorrencia','envolvidos','drogas'));
     
    }

    public function detalhe($id)
    {
      $ocorrencia = Ocorrencia::find($id);
      if(!$ocorrencia){
        abort(404);
      }
      $envolvidos = $ocorrencia->envolvidos;
      $drogas = $ocorrencia->drogas;
      return view('servicooperacional.ocorrencia.detalhe', compact('ocorrencia','envolvidos','drogas'));
   
    }

}
