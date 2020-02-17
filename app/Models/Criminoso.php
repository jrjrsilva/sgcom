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

    function faccao() {
        return $this->belongsTo(Faccao::class,'faccao_id');
    }

    function aisp() {
        return $this->belongsTo(Aisp::class);
    }

   
   
}
