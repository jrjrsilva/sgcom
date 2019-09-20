<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPneu extends Model
{
    protected $table = 'tipo_pneu';

    protected $guarded = ['id','created_at','updated_at'];
}
