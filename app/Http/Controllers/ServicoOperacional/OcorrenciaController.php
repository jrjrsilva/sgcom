<?php

namespace sgcom\Http\Controllers\ServicoOperacional;


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
//use sgcom\Http\Requests\OcorrenciaValidateRequest;
use Illuminate\Http\Request;

class OcorrenciaController extends Controller
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
 
   
    public function index(Ocorrencia $ocorrencia)
    {
      $files = File::all();
      $this->ocorrencia = $ocorrencia;
      $envolvidos       = $this->ocorrencia->envolvidos;
      $drogas           = $this->ocorrencia->drogas;
     
      return  view('servicooperacional.ocorrencia.index',compact('envolvidos','ocorrencia','drogas','files'));
    }

    public function escala()
    {
      return  view('servicooperacional.escala.index');
    }

    public function produtividade()
    {
      return  view('servicooperacional.produtividade.index');
    }

    public function listar()
    {

      $this->authorize('ocorrencia-list');

      $ocorrencias = Ocorrencia::orderBy('data', 'desc')->paginate($this->totalPage);
      $cvli = DB::table('ocorrencia')
              ->join('tipo_ocorrencia','ocorrencia.tipoocorrencia_id','tipo_ocorrencia.id')
              ->where('tipo_ocorrencia.indice_id', 1)
              ->count();
      if($cvli > 0)
        $pcvli = ($cvli * 100)/257;
        else $pcvli = 0;

      $cvp = DB::table('ocorrencia')
              ->join('tipo_ocorrencia','ocorrencia.tipoocorrencia_id','tipo_ocorrencia.id')
              ->where('tipo_ocorrencia.indice_id', 2)
              ->count();
      if($cvp > 0)
        $pcvp = ($cvp * 100)/2074;
        else $pcvp = 0;

      $homicidio = DB::table('ocorrencia')
            ->where('tipoocorrencia_id', 1)
            ->count();
      if($homicidio > 0)
      $phomicidio = ($homicidio * 100)/2074;
          else 
      $phomicidio = 0;

      return view('servicooperacional.ocorrencia.listarocorrencias',
      compact('ocorrencias','tiposocorrencias','cvli','cvp','pcvli','pcvp','phomicidio','homicidio'));
    }



    public function salvar(Request $request)
    {
    // dd($request->all());
   
      $ocorrencia = new Ocorrencia();

      if($request->id != null)
        $ocorrencia = Ocorrencia::find($request->id);
     
      $ocorrencia->opm_id               = $request->opm;
      $ocorrencia->data                 = $request->data_ocorre;
      $ocorrencia->hora                 = $request->hora_ocorre;
      $ocorrencia->tipoocorrencia_id    = $request->tipo_ocorr;
      $ocorrencia->ocorrencia_local     = $request->local_ocorrencia;
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

      $ocorrencia->entrada_onibus         =$request->entradaOnibus;
      $ocorrencia->saida_onibus           =$request->saidaOnibus;
      $ocorrencia->anuncio_assalto_onibus =$request->anuncioAssaltoOnibus;
      $ocorrencia->sigip_onibus           =$request->sigipOnibus;

      $ocorrencia->marca_veiculo_id          =$request->marcaveiculo;
      $ocorrencia->modelo_veiculo_id         =$request->modeloveiculo;
      $ocorrencia->tipo_veiculo           =$request->tipoveiculo;
      $ocorrencia->placa_veiculo          =$request->placaveiculo;

      $ocorrencia->lat                    =$request->latitude;
      $ocorrencia->lng                    =$request->longitude;

      if(Auth::check()){
        $ocorrencia->user_id              = Auth::user()->id;
      }

      $response = $ocorrencia->save();

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

    //    if($response['success'])
              return $this->listar();//view('servicooperacional.ocorrencia.index', compact('envolvidos','ocorrencia'));

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

    public function excluir($id)
    {
      $ocorrencia = Ocorrencia::find($id);
      if(!$ocorrencia){
        abort(404);
      }
      $envolvido = Envolvido::where('ocorrencia_id', '=', $id)->delete();
      $droga = Droga::where('ocorrencia_id', '=', $id)->delete();
      $ocorrencia->delete();
      return $this->listar();
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


    public function store(OcorrenciaValidateRequest $request)
    {
        // Define o valor default para a variável que contém o nome da imagem 
        $nameFile = null;
     
        // Verifica se informou o arquivo e se é válido
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
             
            // Define um nome aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));
     
            // Recupera a extensão do arquivo
            $extension = $request->image->extension();
     
            // Define finalmente o nome
            $nameFile = "{$name}.{$extension}";
     
            // Faz o upload:
            $upload = $request->image->storeAs('arquivos', $nameFile);
            // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao
     
            // Verifica se NÃO deu certo o upload (Redireciona de volta)
            if ( !$upload )
                return redirect()
                            ->back()
                            ->with('error', 'Falha ao fazer upload')
                            ->withInput();
     
        }
    }

    public function search(Request $request, Ocorrencia $ocorrencia)
    { 
      // dd($request->all());
      $dataForm = $request->all();
 
      $ocorrencias =  $ocorrencia->search($dataForm, $this->totalPage);
    
      $cvli = DB::table('ocorrencia')
              ->join('tipo_ocorrencia','ocorrencia.tipoocorrencia_id','tipo_ocorrencia.id')
              ->where('tipo_ocorrencia.indice_id', 1)
              ->count();
      if($cvli > 0)
        $pcvli = ($cvli * 100)/257;
        else $pcvli = 0;
        
      $cvp = DB::table('ocorrencia')
              ->join('tipo_ocorrencia','ocorrencia.tipoocorrencia_id','tipo_ocorrencia.id')
              ->where('tipo_ocorrencia.indice_id', 2)
              ->count();
      if($cvp > 0)
        $pcvp = ($cvp * 100)/2074;
        else $pcvp = 0;

      $homicidio = DB::table('ocorrencia')
            ->where('tipoocorrencia_id', 1)
            ->count();
      if($homicidio > 0)
      $phomicidio = ($homicidio * 100)/2074;
          else 
      $phomicidio = 0;

      return view('servicooperacional.ocorrencia.listarocorrencias', compact('ocorrencias','cvli','cvp','pcvli','pcvp','phomicidio','homicidio'));
    }
}
