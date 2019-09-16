<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Ocorrencia extends Model
{
    protected $table = 'ocorrencia';

    protected $guarded = ['id','created_at','updated_at'];

    function user() {
        return $this->belongsTo(User::class);
    }

    function marcaveiculo() {
        return $this->belongsTo(MarcaVeiculo::class,'marca_veiculo_id');
    }

    function modeloveiculo() {
        return $this->belongsTo(ModeloVeiculo::class,'modelo_veiculo_id');
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

    function totalCvli()
    {
    $retorno =  $this->withCount([
        'Total CVLI' => function ($query) {
                    $query->select(DB::raw("SUM(tipoocorrencia_id) as paidsum"))
                    ->where('tipoocorrencia_id', 1);
                }
        ]);
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
