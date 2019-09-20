<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class SituacaoViatura extends Model
{
    protected $table = 'situacao_viatura';

    protected $guarded = ['id','created_at','updated_at'];

    
}
