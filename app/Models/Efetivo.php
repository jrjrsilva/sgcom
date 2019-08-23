<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Efetivo extends Model
{
    //
    protected $table = 'pmgeral';

    protected $guarded = ['id','created_at','updated_at'];

    public function grauhierarquico(){
        return $this->belongsTo(GrauHierarquico::class);
    }

    public function opm(){
        return $this->belongsTo(Opm::class);
    }
    
    public function search(Array $dataForm, $totalPage)
    {
    //$retorno =
     return 
     $this->where(function($query) use ($dataForm){
        if(isset($dataForm['matricula'])){
            $query->where('matricula','LIKE','%' .$dataForm['matricula'].'%');
        }    
    })
    ->paginate($totalPage);
   // ->toSql();
    //dd($retorno);
    
    }

    public function searchUnique(Array $dataForm, $totalPage)
    {
     return 
     //$retorno =
     $this->
     where(function($query) use ($dataForm){
        if(isset($dataForm['pnome'])){
            $query->where('nome','LIKE','%' .$dataForm['pnome'].'%');
        }
        if(isset($dataForm['pmatricula'])){
            $query->where('matricula','=',$dataForm['pmatricula']);
        }  
        if(isset($dataForm['popm'])){
            $query->where('opm_id','=',$dataForm['popm']);
        }  
    })->orderBy('grauhierarquico_id', 'DESC')
    ->paginate($totalPage);
    //->toSql();
   // dd($retorno);
    
    }

}
