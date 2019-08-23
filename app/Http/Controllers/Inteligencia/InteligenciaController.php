<?php

namespace sgcom\Http\Controllers\Inteligencia;

use Illuminate\Http\Request;
use sgcom\Http\Controllers\Controller;

class InteligenciaController extends Controller
{
    public function index()
    {
      return view('inteligencia.index');
    }
}
