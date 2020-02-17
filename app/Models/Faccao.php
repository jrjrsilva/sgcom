<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Faccao extends Model
{
    protected $table = 'faccao';
    protected $fillable = ['nome','descricao'];

    public $timestamps = false;

   
}
