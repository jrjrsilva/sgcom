<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Arma extends Model
{
    protected $table = 'arma';

    protected $guarded = ['id'];

    public $timestamps = false;

    function opm() {
        return $this->belongsTo(Opm::class);
    }

    function calibre() {
        return $this->belongsTo(Calibre::class,'calibre_id');
    }

    function especiearma() {
        return $this->belongsTo(EspecieArma::class,'especie_da_arma');
    }

    function situacaoarma() {
        return $this->belongsTo(SituacaoArma::class,'situacao');
    }

    public function search(Array $dataForm, $totalPage)
    {
     return 
     //$retorno =
     $this->
     where(function($query) use ($dataForm){
        if(isset($dataForm['pserial'])){
            $query->where('numero_de_serie','like','%'.$dataForm['pserial'].'%');
        }
        if(isset($dataForm['psituacao'])){
            $query->where('situacao','=',$dataForm['psituacao']);
        }
        if(isset($dataForm['pespecie'])){
            $query->where('especie_da_arma','=',$dataForm['pespecie']);
        } 
        if(isset($dataForm['pcalibre'])){
            $query->where('calibre_id','=',$dataForm['pcalibre']);
        }  
       if(isset($dataForm['popm'])){
            $query->where('opm_id','=',$dataForm['popm']);
        }  
    })->orderBy('numero_de_serie', 'asc')
    ->paginate($totalPage);
    //->toSql();
   // dd($retorno);
    
    }
}
