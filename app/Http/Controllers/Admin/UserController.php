<?php

namespace sgcom\Http\Controllers\Admin;


use sgcom\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        return view('site.profile.profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->all();

       if($data['password'] != null)
            $data['password'] = bcrypt($data['password']);
        else
           unset($data['password']);

      // $data['image'] = $user->image;

       if($request->hasfile('image') && $request->file('image')->isvalid()){
           
                $name = $user->efetivo->matricula;
                // Define um aleatório para o arquivo baseado no timestamps atual
                //para usar na ocorrencia
                //$name = uniqid(date('HisYmd'));


                   $extenstion = $request->image->extension();
                   $nameFile = "{$name}.{$extenstion}";

                   $upload = $request->image->storeAs('users',$nameFile);

                   $data['image'] = $nameFile;
                   
                   if(!$upload)
                   return redirect()->back()->with('error', 'Falha ao fazer upload da imagem!');

       }

       $update = auth()->user()->update($data);

       if($update)
            return redirect()->route('profile')->with('success','Perfil atualizado');

            return redirect()->back()->with('error', 'Falha ao atualizar o perfil!');
    }
}
