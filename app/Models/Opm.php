<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Opm extends Model
{
    protected $table = 'opm';

    public $timestamps = false;

    public function search(Array $dataForm, $totalPage)
    {
    //$retorno =
     return 
     $this->where(function($query) use ($dataForm){
        if(isset($dataForm['opm_sigla'])){
            $query->where('opm_sigla','LIKE','%' .$dataForm['opm_sigla'].'%');
        }    
    })
    ->paginate($totalPage);
   // ->toSql();
    //dd($retorno);
    
    }

    public function cpr(){
        return $this->belongsTo(Cpr::class);
    }

    public function secoes($opm){
        return $this->whereIn([1,3])->get();   
    }

}
