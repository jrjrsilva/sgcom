<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAtuacaoCriminoso extends Model
{
    protected $table = 'tipo_atuacao_criminoso';
    protected $fillable = ['nome','descricao'];

    public $timestamps = false;

   
}
