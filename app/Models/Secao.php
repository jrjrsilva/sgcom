<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Secao extends Model
{
    protected $table = 'secao';

    protected $guarded = ['id'];

    public $timestamps = false;

}
