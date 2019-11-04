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
      $cvlis = DB::table('ocorrencia')
      ->join('tipo_ocorrencia','ocorrencia.tipoocorrencia_id','tipo_ocorrencia.id')
      ->where('tipo_ocorrencia.indice_id', 1)
      ->select(DB::raw("ocorrencia_local as name, concat(lat,',' , lng) as location"))
      ->get()->toJson();
      return view('cvli.index',compact('cvlis'));
    }

  
    public function json() {
      try {
          $ocorrencias =DB::table('ocorrencia')
          ->join('tipo_ocorrencia','ocorrencia.tipoocorrencia_id','tipo_ocorrencia.id')
          ->where('tipo_ocorrencia.indice_id', 1)
          ->select(DB::raw("ocorrencia_local as name, lat,lng"));
                  return response()->json($ocorrencias);
              } catch (\Exception $e) {
                  return Redirect::back()->withErros(["Erro! Não foi possível abrir."]);
              }
          }

      
}
