<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class ModusOperandi extends Model
{
    protected $table = 'modus_operandi';
    protected $fillable = ['nome','descricao'];

    public $timestamps = false;

   
}
