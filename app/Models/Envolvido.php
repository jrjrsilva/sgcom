<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Envolvido extends Model
{
    protected $table = 'envolvido';
    
    protected $fillable = ['name','sexo','idade','ocorrencia_id','tipo_envol'];

}
