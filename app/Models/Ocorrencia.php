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
   
}
