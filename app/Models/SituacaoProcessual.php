<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class SituacaoProcessual extends Model
{
    protected $table = 'situacao_processual';
    protected $fillable = ['nome','descricao'];

    public $timestamps = false;

   
}
