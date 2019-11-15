<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    
    protected $table = 'file';
    protected $fillable = ['nome', 'mime', 'caminho', 'tamanho'];

    public $timestamps = false;
}
