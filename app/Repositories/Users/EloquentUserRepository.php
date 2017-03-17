<?php

namespace App\Repositories\Users;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
