<?php

namespace sgcom\Http\Controllers\Site;

use Illuminate\Http\Request;
use sgcom\Http\Controllers\Controller;

class SGCOMController extends Controller
{
    //
    public function index()
    {
        return view('site.home.index');
    }

    public function home()
    {
        return view('site.auth.index');
      //return 'Tela pois login';
    }
}
