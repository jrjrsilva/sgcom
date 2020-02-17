<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class PosicaoFaccao extends Model
{
    protected $table = 'posicao_faccao';
    protected $fillable = ['nome','descricao'];

    public $timestamps = false;

   
}
