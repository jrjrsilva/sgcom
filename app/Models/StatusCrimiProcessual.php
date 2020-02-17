<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class StatusCrimiProcessual extends Model
{
    protected $table = 'status_processual';

    protected $fillable = ['situacao_processual_id','nome'];

    protected $guarded = ['id'];

    public $timestamps = false;

    

}
