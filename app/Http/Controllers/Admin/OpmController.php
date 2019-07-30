<?php

namespace sgcom\Http\Controllers\Admin;

use Illuminate\Http\Request;
use sgcom\Http\Controllers\Controller;
use sgcom\Models\Opm;

class OpmController extends Controller
{
  private $totalPage = 15;

    public function index()
    {
      $opms = Opm::where('cpr_id','=',12)->paginate($this->totalPage);

      return view('admin.opm.index', compact('opms'));

    }

    public function nova()
    {
      $opms = Opm::paginate($this->totalPage);

      return view('admin.opm.index', compact('opms'));

    }

    public function searchOpm(Request $request, Opm $opm)
    {
      // dd($request->all());
      $dataForm = $request->all();
 
      $opms =  $opm->search($dataForm, $this->totalPage);
 
      return view('admin.opm.index', compact('opms'));
    }
}
