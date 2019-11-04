<?php

namespace sgcom\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use sgcom\Models\Efetivo;
use sgcom\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'sgcom\Model' => 'sgcom\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('rh-list',function($user, $efetivo){
            return $user->efetivo->opm->cpr->id == $efetivo->opm->id;
            });
    }
}
