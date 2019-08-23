<?php

namespace sgcom\Http\Controllers\PainelGestao;

use Illuminate\Http\Request;
use sgcom\Http\Controllers\Controller;

class PainelGestaoController extends Controller
{
    public function index()
    {
      return view('painelgestao.index');
    }
}
