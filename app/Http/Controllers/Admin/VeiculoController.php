<?php

namespace sgcom\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use sgcom\Http\Controllers\Controller;

class VeiculoController extends Controller
{
    public function getModelosVeiculo($id_veiculo)
    {

       $modelosveiculo =  DB::table('modelo_veiculo')
       ->where('marca_veiculo_id', $id_veiculo)
       ->get(['id', 'descricao']);

        return response()->json($modelosveiculo);

    }

}