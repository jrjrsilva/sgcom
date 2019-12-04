<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoPolicial extends Model
{
    protected $table = 'historico_policial';

    protected $fillable = ['efetivo_id','observacao','data_inicio','data_fim'];

    protected $guarded = ['id','created_at','updated_at'];

    function tipohistorico() {
        return $this->belongsTo(TipoHistorico::class, 'tipo_historico_id');
    }


}
