<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Bateria extends Model
{
    protected $table = 'bateria';

    protected $guarded = ['id',];

    public $timestamps = false;
}
