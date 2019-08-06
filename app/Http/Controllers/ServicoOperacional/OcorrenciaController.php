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
      $envolvidos = $this->ocorrencia->envolvidos;
      return  view('servicooperacional.ocorrencia.index',compact('envolvidos','ocorrencia'));
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
      $envolvido  = $request->envolvido;
      $idade      = $request->idade;
      $tipo       = $request->tipo_envolvimento;
      $sexo       = $request->sexo;
      $rg         = $request->rg;

      if(is_array($envolvido)){
        $keys = array_keys($envolvido);

        $size = count($envolvido);
       
        for ($i = 0; $i < $size; $i++) {
            $key   = $keys[$i];

            $objEnv = new Envolvido();
            $objEnv->nome           = $envolvido[$key];
            $objEnv->idade          = $idade[$key];
            $objEnv->tipo_envol     = $tipo[$key];
            $objEnv->sexo           = $sexo[$key];
            $objEnv->rg             = $rg[$key];
            $objEnv->ocorrencia_id  = $request->id;
            $objEnv->save(); 
        }

      } else {
        dd($request->all());
      }
            
     
   /*
      $ocorrencia = new ocorrencia();

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
     // $ocorrencia->$request->"tipo_droga" => "Selecione o tipo de droga"
      //$ocorrencia->$request->"desc_outra_droga" => null
      //$ocorrencia->$request->"qtd_droga" => null
      if(Auth::check()){
        $ocorrencia->user_id              = Auth::user()->id;
      }

      $ocorrencia->save();

      $envolvidos = $ocorrencia->envolvidos;
*/
      return $this->dashboard();//view('servicooperacional.ocorrencia.index', compact('envolvidos','ocorrencia'));

    }

    public function edit($id)
    {
      $ocorrencia = Ocorrencia::find($id);
      if(!$ocorrencia){
        abort(404);
      }
      $envolvidos = $ocorrencia->envolvidos;

      return view('servicooperacional.ocorrencia.index', compact('ocorrencia','envolvidos'));
     
    }

    public function alterar($ocorrencia, $request)
    {
        $params = $request->all();
        $ocorrencia = new Ocorrencia($params);
        $ocorrencia->save();
        return dashboard();
    }
}
