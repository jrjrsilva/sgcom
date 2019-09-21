<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Calibre extends Model
{
    protected $table = 'calibre_arma';

    protected $guarded = ['id','nome'];

    public $timestamps = false;
}
