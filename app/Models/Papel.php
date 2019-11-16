<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class Papel extends Model
{
    protected $table = 'papeis';
    protected $fillable = ['nome','descricao'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissoes()
    {
        return $this->belongsToMany(Permissao::class);
    }
}
