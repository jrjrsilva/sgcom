<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Aisp extends Model
{

    public $timestamps = false;

public function search(Array $dataForm, $totalPage)
{
   // $retorno =
     return 
     $this->where(function($query) use ($dataForm){
        if(isset($dataForm['descricao'])){
            $search =  $dataForm['descricao'];
            $query->where('descricao','LIKE','%' .$dataForm['descricao'].'%');
        }
            
    })
    ->paginate($totalPage);
    //->toSql();
    //dd($retorno);
    
}

}
