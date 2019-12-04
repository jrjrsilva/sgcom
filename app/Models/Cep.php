<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Cep extends Model
{
    protected $table = 'cep';

    public function obterEndereco($cep)
    {
    
     return $this->where('cep','=',$cep)->get();
        
    }
}
