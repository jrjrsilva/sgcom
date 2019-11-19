<?php

namespace sgcom\Policies;

use sgcom\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PapelPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(User $user){
        return $user->id == 1;
    }
}
