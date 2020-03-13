<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Viatura extends Model
{
    protected $table = 'viatura';

    protected $guarded = ['id','created_at','updated_at'];

    function marcaveiculo() {
        return $this->belongsTo(MarcaVeiculo::class,'marca_veiculo_id');
    }

    function modeloveiculo() {
        return $this->belongsTo(ModeloVeiculo::class,'modelo_veiculo_id');
    }

    function opm() {
        return $this->belongsTo(Opm::class);
    }

    function bateria() {
        return $this->belongsTo(Bateria::class);
    }

    function combustivel() {
        return $this->belongsTo(Combustivel::class);
    }

    function tipopneu() {
        return $this->belongsTo(TipoPneu::class,'tipo_pneu_id');
    }

    function situacaoviatura() {
        return $this->belongsTo(SituacaoViatura::class,'situacao_viatura_id');
    }

    public function search(Array $dataForm, $totalPage)
    {
     return 
     //$retorno =
     $this->
     where(function($query) use ($dataForm){
        if(isset($dataForm['situacao'])){
            $query->where('situacao_viatura_id','=',$dataForm['situacao']);
        }
       if(isset($dataForm['popm'])){
            $query->where('opm_id','=',$dataForm['popm']);
        }  
    })
    ->where('situacao_viatura_id','<>',1)
    ->orderBy('km', 'desc')
    ->paginate($totalPage);
    //->toSql();
   // dd($retorno);
    
    }

}
