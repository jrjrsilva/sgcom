<?php

namespace sgcom\Http\Controllers\Armamento;

use Illuminate\Http\Request;
use sgcom\Http\Controllers\Controller;

class ArmamentoController extends Controller
{
    public function lista()
    {
      return view('armas.lista');
    }
}
