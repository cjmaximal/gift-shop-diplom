<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;

class EloquentAdminUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        $user = parent::retrieveByCredentials($credentials);

        return $user && $user->isAdmin() === false
            ? null
            : $user;
    }
}