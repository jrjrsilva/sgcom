<?php

namespace sgcom\Http\Controllers\Admin;

use Faker\Provider\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use sgcom\Http\Controllers\Controller;
use Illuminate\Http\Request;
use sgcom\User;
use sgcom\Models\Opm;
use sgcom\Models\Efetivo;
use sgcom\Models\GrauHierarquico;
use sgcom\Models\Papel;

class UserController extends Controller
{
    private $totalPage = 15;

    public function __construct() {


        $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=','12')->get();
               
        $ghs = GrauHierarquico::orderBy('precedencia','asc')->get();

        $url = null;

      view()->share(compact('opms','ghs','url'));
      }

    public function index()
    {
       $users = DB::table('users')
        ->join('pmgeral', 'users.efetivo_id','=','pmgeral.id')
        ->join('grauhierarquico', 'pmgeral.grauhierarquico_id','=','grauhierarquico.id')
        ->join('opm', 'pmgeral.opm_id','=','opm.id')
        ->select('users.id','opm_sigla','matricula','nome','grauhierarquico.sigla','status','image','users.email')
        ->orderBy('pmgeral.grauhierarquico_id', 'DESC')
        
        ->paginate($this->totalPage);
        //->toSql();
        //dd($users);

        return view('admin.usuarios.index',compact('users'));
    }
    
    public function profile()
    {
        return view('site.profile.profile');
    }

    public function papel($id){
        $usuario = User::find($id);
        $papeis = Papel::all();
        return view('admin.usuarios.papel',compact('usuario','papeis'));
    }

    public function papelSalvar(Request $request, $id){
        $usuario    = User::find($id);
        $dados      = $request->all();

        $papel = Papel::find($dados['papel_id']);
        $usuario->adicionarPapel($papel);

        return redirect()->back();
    }

    public function papelDestroy($id, $papel_id){
        $usuario    = User::find($id);
      
        $papel = Papel::find($papel_id);
        $usuario->removerPapel($papel);

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->all();

      /*  if($data['password'] != null)
            $data['password'] = bcrypt($data['password']);
        else
           unset($data['password']); */

      // $data['image'] = $user->image;

       if($request->hasfile('image') && $request->file('image')->isvalid()){
           
                $name = $user->efetivo->matricula;
               
                // Define um nome aleatório para o arquivo baseado no timestamps atual
                //$name = uniqid(date('HisYmd'));


                   $extenstion = $request->image->extension();
                   $nameFile = "{$name}.{$extenstion}";

                   $upload = $request->image->move('img_perfil',$nameFile);

                   $data['image'] = $nameFile;
                   
                   if(!$upload)
                   return redirect()->back()->with('error', 'Falha ao fazer upload da imagem!');

       }

       $update = auth()->user()->update($data);

       if($update)
            return redirect()->route('profile')->with('success','Perfil atualizado');

            return redirect()->back()->with('error', 'Falha ao atualizar o perfil!');
    }

    public function salvar(Request $request)
    {
        try{
            $user = User::findOrFail($request->id);
        $user->email= $request->email;
        $user->status = $request->status;
        $opm = Opm::find($request->opm);
        $gh = GrauHierarquico::find($request->gh);
        $efetivo = Efetivo::find($user->efetivo_id);
        $efetivo->opm()->associate($opm)->save();
        $efetivo->grauhierarquico()->associate($gh)->save();
        $efetivo->save();
        $user->save();

        return back()->with('success','Usuário atualizado');

        }catch (\Exception $e){
            return back()->with('error', 'Falha ao atualizar o usuário!'.$e);
        }
      }

    public function search(Request $dataForm)
    {
     
     $users = DB::table('users')
    ->join('pmgeral', 'users.efetivo_id','=','pmgeral.id')
    ->join('grauhierarquico', 'pmgeral.grauhierarquico_id','=','grauhierarquico.id')
    ->join('opm', 'pmgeral.opm_id','=','opm.id')
    ->when($dataForm['pnome'], function($queryNome) use ($dataForm){
        return $queryNome->where('pmgeral.nome','LIKE','%' .$dataForm['pnome'].'%');
        })
    ->when($dataForm['pmatricula'],function($queryMatricula) use ($dataForm){
         return $queryMatricula->where('pmgeral.matricula',$dataForm['pmatricula']);
        })
    ->when($dataForm['pstatus'],function($queryStatus) use ($dataForm){
            return $queryStatus->where('status','=',$dataForm['pstatus']);
           })
    ->when($dataForm['popm'],function($queryOpm) use ($dataForm){
          return $queryOpm->where('pmgeral.opm_id',$dataForm['popm']);
        })->orderBy('pmgeral.grauhierarquico_id', 'DESC')
    ->select('users.id','opm_sigla','matricula','nome','grauhierarquico.sigla','status','image','users.email')
    ->paginate($this->totalPage);
    //->toSql();
    //dd($users);
    
    return view('admin.usuarios.index',compact('users','dataForm'));
    }

    public function status($id)
    {
        $user = User::find($id);
        if(!$user){
            abort(404);
          }

        if($user->status == 'Ativo'){
            $user->status = 'Inativo';
        }else{
            $user->status = 'Ativo';
        }
            
        
        $update = $user->save();

        if($update)
            return redirect()->route('admin.usuarios')->with('success','Perfil atualizado');

            return redirect()->back()->with('error', 'Falha ao atualizar o perfil!');

    }

    public function edit($id)
    {
        $user = User::find($id);
        if(!$user){
            abort(404);
          }

          $url = Storage::url($user->image);
          $usuario = $user;
          $papeis = Papel::all();
       
          return view('admin.usuarios.form',compact('user','url','usuario','papeis'));
    }

    public function getPicture() {
        return image::make(public_path('/img_perfil/' . Auth::user()->image))->response();
    }

   
}
