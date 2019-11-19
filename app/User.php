<?php

namespace sgcom;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use sgcom\Models\Efetivo;
use sgcom\Models\Papel;
use sgcom\Models\Permissao;

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

    public function ehAdmin(){
        return $this->existePapel('Admin');
    }

    public function efetivo(){
        return $this->belongsTo(Efetivo::class);
    }

    public function papeis()
    {
        return $this->belongsToMany(Papel::class);
    }

    public function adicionarPapel($papel){
        if(is_string($papel)){
            $papel = Papel::where('nome','=',$papel)->firstOrFail();
        }

        if($this->existePapel($papel)){
            return ;
        }

        return $this->papeis()->attach($papel);
    }

    public function existePapel($papel){
        if(is_string($papel)){
            $papel = Papel::where('nome','=',$papel)->firstOrFail();
        }

        return (boolean) $this->papeis()->find($papel->id);
    }

    public function removerPapel($papel){
        if(is_string($papel)){
            $papel = Papel::where('nome','=',$papel)->firstOrFail();
        }

        return $this->papeis()->detach($papel);
    }

    public function temUmPapelDestes($papeis){
        $userPapeis = $this->papeis;
        return !! collect([$papeis])->intersect($userPapeis)->count();
    }

    public function hasPermission(Permissao $permissao) { 
        return $this->hasAnyRoles($permissao->papeis); 
      }

    public function hasAnyRoles($papeis){
        if(is_array($papeis) or is_object($papeis) ){
           return !! $papeis->intersect($this->papeis)->count();    
        }
        return $this->papeis->contains('nome',$papeis);
    }
}
