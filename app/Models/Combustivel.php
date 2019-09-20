<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Combustivel extends Model
{
    //

    protected $table = 'combustivel';

    protected $guarded = ['id','created_at','updated_at'];

}
