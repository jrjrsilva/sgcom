<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentosCriminoso extends Model
{
    protected $table = 'documentos_criminoso';

   protected $fillable = ['documento', 'descricao','criminoso_id'];

    public $timestamps = false;

}
