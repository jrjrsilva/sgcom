<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Cpr extends Model
{
    protected $table = 'cpr';

    public $timestamps = false;

    public function opms(){
        return $this->hasMany(OPM::class);
    }
}