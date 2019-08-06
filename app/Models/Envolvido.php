<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Envolvido extends Model
{
    protected $table = 'envolvido';
    
    protected $fillable = ['nome','sexo','idade','ocorrencia_id','tipo_envol','rg'];

}
