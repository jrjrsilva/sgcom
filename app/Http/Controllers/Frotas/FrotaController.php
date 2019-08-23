<?php

namespace sgcom\Http\Controllers\Frotas;

use Illuminate\Http\Request;
use sgcom\Http\Controllers\Controller;

class FrotaController extends Controller
{
    public function index()
    {
      return view('frota.lista');
    }
}
