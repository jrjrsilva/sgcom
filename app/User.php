<?php

namespace sgcom;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use sgcom\Models\Efetivo;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image','status','efetivo_id'];

    
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function efetivo(){
        return $this->belongsTo(Efetivo::class);
    }
}
