<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Funcao extends Model
{
    protected $table = 'funcao';

    protected $guarded = ['id'];

    public $timestamps = false;

}
