<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class SituacaoArma extends Model
{
    protected $table = 'situacao_arma';

    protected $guarded = ['id','nome'];

    public $timestamps = false;
}
