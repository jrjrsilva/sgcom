<?php

namespace sgcom\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use sgcom\Models\Opm;
use sgcom\Models\Efetivo;
use sgcom\Http\Controllers\Controller;
use Illuminate\Http\Request;
use sgcom\User;

class UserController extends Controller
{
    private $totalPage = 15;

    public function __construct() {


        $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=','12')->get();
               
        view()->share(compact('opms'));
      }

    public function index()
    {
       $users = DB::table('users')
        ->join('pmgeral', 'users.efetivo_id','=','pmgeral.id')
        ->join('grauhierarquico', 'pmgeral.grauhierarquico_id','=','grauhierarquico.id')
        ->join('opm', 'pmgeral.opm_id','=','opm.id')
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

    public function searchOld(Request $request, User $user)
    {
      // dd($request->all());
      $dataForm = $request->except('_token');
 
      $users =  $user->search($dataForm, $this->totalPage);
     // dd($efetivos);

      return view('admin.usuarios.index',compact('users','dataForm'));
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
    ->when($dataForm['popm'],function($queryOpm) use ($dataForm){
          return $queryOpm->where('pmgeral.opm_id',$dataForm['popm']);
        })->orderBy('pmgeral.grauhierarquico_id', 'DESC')
    
    ->paginate($this->totalPage);
    //->toSql();
    //dd($users);
    
    return view('admin.usuarios.index',compact('users','dataForm'));
    }
}
