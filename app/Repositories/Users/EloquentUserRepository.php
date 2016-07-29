<?php

namespace App\Repositories\Users;

use Auth;
use App\User;
use App\Repositories\Users\UserRepository;

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
