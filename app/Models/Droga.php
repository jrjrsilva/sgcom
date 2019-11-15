<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Droga extends Model
{
    protected $table = 'droga'; 

    protected $fileable =['tipo_droga','descricao_droga','quantidade_droga'];

    public $timestamps = false;
}
