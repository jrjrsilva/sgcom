<?php

namespace sgcom\Http\Controllers\Cvli;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use sgcom\Http\Controllers\Controller;
use sgcom\Models\Ocorrencia;


class CvliController extends Controller
{
    public function index()
    {
     return view('cvli.index');
    }

  
    public function json() {
      try {
        return  DB::table('ocorrencia')
        ->join('tipo_ocorrencia','ocorrencia.tipoocorrencia_id','tipo_ocorrencia.id')
        ->join('envolvido','ocorrencia.id','envolvido.ocorrencia_id')
        ->where('tipo_ocorrencia.indice_id', 1)
	      ->where('lat','!=','null')
        ->select(DB::raw("ocorrencia_local as name, lat,lng,tipo_ocorrencia.descricao, ocorrencia.id, concat(envolvido.nome,' - ',envolvido.tipo_envol) as envolvido"))
        ->get()->toJson();
                    } catch (\Exception $e) {
                  return Redirect::back()->withErros(["Erro! Não foi possível abrir."]);
              }
          }
      
}
