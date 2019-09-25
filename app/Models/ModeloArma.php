<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloArma extends Model
{
    protected $table = 'modelo_arma';

    protected $guarded = ['id','nome','tipo'];

    public $timestamps = false;
}
