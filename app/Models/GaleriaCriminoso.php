<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class GaleriaCriminoso extends Model
{
    protected $table = 'galeria_criminoso';

   protected $fillable = ['foto', 'descricao','criminoso_id'];

    public $timestamps = false;

}
