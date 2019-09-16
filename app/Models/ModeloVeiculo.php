<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloVeiculo extends Model
{
    protected $table='modelo_veiculo';

    protected $guarded = ['id','created_at','updated_at'];
}
