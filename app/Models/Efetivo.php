<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Efetivo extends Model
{
    //
    protected $table = 'pmgeral';

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
     $this->where(function($query) use ($dataForm){
        if(isset($dataForm['matricula'])){
            $query->where('matricula','=',$dataForm['matricula']);
        } 
        
        if(isset($dataForm['opm'])){
            $query->where('opm_id','=',$dataForm['opm']);
        }  
    })->orderBy('grauhierarquico_id', 'ASC')
    ->paginate($totalPage);
    //->toSql();
    //dd($retorno);
    
    }
}
