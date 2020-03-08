<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use sgcom\User;

class Criminoso extends Model
{
    use SoftDeletes;

    protected $table = 'criminoso';

    protected $guarded = ['id','created_at','updated_at'];

    protected $dates = ['deleted_at'];
    

    
    function posicaofaccao() {
        return $this->belongsTo(PosicaoFaccao::class,'posicao_faccao_id');
    }

    function situacaoprocessual() {
        return $this->belongsTo(SituacaoProcessual::class,'situacao_processual_id');
    }

    function historicosituacaoprocessual() {
        return $this->hasMany(HistoricoCrimiProcessual::class,'criminoso_id');
    }

    function galeriacriminoso() {
        return $this->hasMany(GaleriaCriminoso::class,'criminoso_id');
    }

    function faccao() {
        return $this->belongsTo(Faccao::class,'faccao_id');
    }

    function aisp() {
        return $this->belongsTo(Aisp::class);
    }

    public function search(Array $dataForm, $totalPage)
    {

     $retorno =
     $this->join('opm','criminoso.opm_id','opm.id')
      ->where(function($query) use ($dataForm){
        if(isset($dataForm['pnome'])){
            $query->where('criminoso.nome','LIKE','%' .$dataForm['pnome'].'%');
        }
        if(isset($dataForm['apelido'])){
            $query->where('apelido','LIKE','%'.$dataForm['apelido'].'%');
        }  
        if(isset($dataForm['popm'])){
            $query->where('opm_id','=',$dataForm['popm']);
        }

        if(isset($dataForm['faccao'])){
            $query->where('criminoso.faccao_id','=',$dataForm['faccao']);
        } 
      
        if(isset($dataForm['pregional'])){
            $query->where('opm.cpr_id','=',$dataForm['pregional']);
        }
       
    })->select('criminoso.id','criminoso.nome','criminoso.apelido','criminoso.foto','criminoso.faccao_id')
    ->orderBy('criminoso.nome', 'DESC')
    ->paginate($totalPage);

   return $retorno;
    }
   
}
