<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class EspecieArma extends Model
{
    protected $table = 'especie_arma';

    protected $guarded = ['id','nome','nome_abreviatura','emprego_ind'];

    public $timestamps = false;
}
