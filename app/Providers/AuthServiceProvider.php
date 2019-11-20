<?php

namespace sgcom\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use sgcom\Models\Efetivo;
use sgcom\Models\Papel;
use sgcom\User;
use sgcom\Models\Permissao;
use sgcom\Policies\PapelPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       // 'sgcom\Model' => 'sgcom\Policies\ModelPolicy',
       // Papel::class => PapelPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        Gate::before(function ($user) {
            if ($user->ehAdmin()) {
                return true;
            }
        });
  
         foreach($this->listaPermissoes() as $permissao){
             Gate::define($permissao->nome,function(User $user) use ($permissao){
                return $user->hasPermission($permissao);
                });
        }
    }

    public function listaPermissoes(){
        return Permissao::with('papeis')->get();
    }

}
