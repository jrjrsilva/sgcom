<?php

namespace sgcom\Http\Controllers\ServicoOperacional;

use Illuminate\Http\Request;
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

    public function __construct() {
      $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=','12')->get();
      $aisps = Aisp::orderBy('descricao', 'asc')->get();
      $delegacias = Delegacia::orderBy('descricao', 'asc')->get();
      $tiposocorrencias = TipoOcorrencia::orderBy('descricao', 'asc')->get();
      
      view()->share(compact('opms','aisps','delegacias','tiposocorrencias'));
    }
 
 
    public function index(Ocorrencia $ocorrencia)
    {
      $envolvidos = $ocorrencia->envolvidos;
      return view('servicooperacional.ocorrencia.index',compact('envolvidos'));
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
      $envolvidos = $request->envolvidos;
     // dd($request->all());
     foreach (['envolvidos'] as $envolvido) 
    { 
    //  dd($envolvidos['tipo_envolv_t']);
      $params = array(
       // 'nome' => $envolvido['nome'],
       // 'sexo' => $envolvido['sexo_t'] ,
        'tipo_envol' =>  $envolvido['tipo_envol_t'],
        'idade' =>  $envolvidos['idade']
      );
      $envolvido = Envolvido::create($params);
         $envolvido->save();
    }
     

     

      /*
      $ocorrencia = new ocorrencia();
      $ocorrencia->opm_id               = $request->opm;
      $ocorrencia->data                 = $request->data_ocorre;
      $ocorrencia->hora                 = $request->hora_ocorre;
      $ocorrencia->tipoocorrencia_id    = $request->tipo_ocorr;
      $ocorrencia->ocorrencia_local     = $request->local_ocorre;
      //$ocorrencia->$request->"tipo_envol" => null
      //$ocorrencia->$request->"envolvido" => null
      //$ocorrencia->$request->"sexo" => null
      //$ocorrencia->$request->"idade" => null
      $ocorrencia->ocorrencia_relatorio = $request->input('desc_ocorrencia');
      $ocorrencia->delegacia_id         = $request->delegacia;
      //$ocorrencia->$request->"end_delegacia" => null
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

      return view('servicooperacional.ocorrencia.index', 'envolvidos');
      */
    }


}
