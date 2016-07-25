<?php

namespace App\Repositories;

use Auth;
use App\User;

class EloquentUserRepository implements UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user->findOrFail(Auth::user()->id);
    }

    public function getAllUsers()
    {
        return $this->user->all();
    }
}
