<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Efetivo extends Model
{
    //
    protected $table = 'efetivo';

    public function grauhierarquico(){
        return $this->belongsTo(GrauHierarquico::class);
    }

    public function opm(){
        return $this->belongsTo(Opm::class);
    }
    
}
