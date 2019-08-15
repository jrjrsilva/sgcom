<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Ocorrencia extends Model
{
    protected $table = 'ocorrencia';

    protected $guarded = ['id','created_at','updated_at'];

    function User() {
        return $this->belongsTo(User::class);
    }

    function envolvidos() {
        return $this->hasMany(Envolvido::class);
    }
    
    function opm() {
        return $this->belongsTo(Opm::class);
    }

    function tipoocorrencia() {
        return $this->belongsTo(TipoOcorrencia::class);
    }

    function aisp() {
        return $this->belongsTo(Aisp::class);
    }

    function delegacia() {
        return $this->belongsTo(Delegacia::class);
    }

    function drogas(){
        return $this->hasMany(Droga::class);
    }

    public function search(Array $dataForm, $totalPage)
    {
    //$retorno =
     return 
     $this->where(function($query) use ($dataForm){
        if(isset($dataForm['opm'])){
            $query->where('opm_id',$dataForm['opm']);
        }    
        if(isset($dataForm['tipo_ocorr'])){
            $query->where('tipoocorrencia_id',$dataForm['tipo_ocorr']);
        } 
        if(isset($dataForm['data_inicio'])){
            $query->where('data','>=',$dataForm['data_inicio']);
        } 
        if(isset($dataForm['data_fim'])){
            $query->where('data','<=',$dataForm['data_fim']);
        } 
    })
    ->paginate($totalPage);
   // ->toSql();
    //dd($retorno);
    
    }
   
}
