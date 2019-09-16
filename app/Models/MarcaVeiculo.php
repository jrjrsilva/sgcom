<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class MarcaVeiculo extends Model
{
    
    protected $table='marca_veiculo';

    protected $guarded = ['id','created_at','updated_at'];

}
