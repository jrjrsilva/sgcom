<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoricoCrimiProcessual extends Model
{
    
    use SoftDeletes;
    
    protected $table = 'historico_criminoso_processual';

    protected $fillable = ['situacao_processual_id','status_processual_id','enquadramento','data_registro','unidade_prisional','user_id'];

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function criminoso()
    {
        return $this->belongsTo(Criminoso::class);
    }

    public function situacaoprocessual()
    {
        return $this->belongsTo(SituacaoProcessual::class,'situacao_processual_id');
    }

    public function statusprocessual()
    {
        return $this->belongsTo(StatusCrimiProcessual::class,'status_processual_id');
    }


}
