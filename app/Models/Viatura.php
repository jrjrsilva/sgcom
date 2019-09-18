<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Viatura extends Model
{
    protected $table = 'viatura';

    protected $guarded = ['id','created_at','updated_at'];

    function marcaveiculo() {
        return $this->belongsTo(MarcaVeiculo::class,'marca_veiculo_id');
    }

    function modeloveiculo() {
        return $this->belongsTo(ModeloVeiculo::class,'modelo_veiculo_id');
    }

    function opm() {
        return $this->belongsTo(Opm::class);
    }

}
