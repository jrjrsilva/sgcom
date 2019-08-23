<?php

namespace sgcom\Http\Controllers\Cvp;

use Illuminate\Http\Request;
use sgcom\Http\Controllers\Controller;

class CvpController extends Controller
{
    public function index()
    {
      return view('cvp.index');
    }
}
