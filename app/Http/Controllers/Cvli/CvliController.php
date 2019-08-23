<?php

namespace sgcom\Http\Controllers\Cvli;

use Illuminate\Http\Request;
use sgcom\Http\Controllers\Controller;

class CvliController extends Controller
{
    public function index()
    {
      return view('cvli.index');
    }
}
