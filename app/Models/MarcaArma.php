<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class MarcaArma extends Model
{
    protected $table = 'marca_arma';

    protected $guarded = ['id','nome'];

    public $timestamps = false;
}
