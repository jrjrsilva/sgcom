<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Ocorrencia extends Model
{
    protected $table = 'ocorrencia';

    function User() {
        return $this->belongsTo(User::class);
    }

    function envolvidos() {
        return $this->hasMany(Envolvido::class);
    }

   
}
