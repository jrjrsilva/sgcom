<?php

namespace sgcom\Http\Controllers\Admin;

use Illuminate\Http\Request;
use sgcom\Http\Controllers\Controller;
use sgcom\Models\Papel;
use sgcom\Models\Permissao;

class PapelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $papeis = Papel::all();
     
      return view('admin.papel.index',compact('papeis'));
    }

    public function permissoes($id)
    {
      $papel = Papel::find($id);
      $permissoes = Permissao::all();
    
      return view('admin.papel.permissao',compact('papel','permissoes'));
    }

    public function permissaoStore(Request $request,$id)
    {
        $papel = Papel::find($id);
        $dados = $request->all();
        $permissao = Permissao::find($dados['permissao_id']);
        $papel->adicionaPermissao($permissao);
        return redirect()->back();
    }

    public function permissaoDestroy($id,$permissao_id)
    {
      $papel = Papel::find($id);
      $permissao = Permissao::find($permissao_id);
      $papel->removePermissao($permissao);
      return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function novo()
    {
      return view('admin.papel.adicionar');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
      return view('admin.papel.adicionar');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if(Papel::find($id)->nome == "Admin"){
          return redirect()->route('papeis.index');
      }

      $papel = Papel::find($id);

      return view('admin.papel.editar',compact('papel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $id = $request['id'];
      if(Papel::find($id)->nome == "Admin"){
          return redirect()->route('admin.papeis');
      }
      if($request['nome'] && $request['nome'] != "Admin"){
        Papel::find($id)->update($request->all());
      }

      return redirect()->route('admin.papeis');
    }

    public function papelSalvar(Request $request)
    {
      if($request['nome'] == "Admin"){
        return redirect()->route('admin.papeis');
      }else {
        Papel::create($request->all());
      }

      return redirect()->route('admin.papeis');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function papelDestroy($id)
    {
      if(Papel::find($id)->nome == "Admin"){
          return redirect()->route('admin.papeis');
      }
      Papel::find($id)->delete();
      return redirect()->route('admin.papeis');
    }
}
