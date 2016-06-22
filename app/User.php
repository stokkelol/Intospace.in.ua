<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\InstanceTrait;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use InstanceTrait;
    use EntrustUserTrait;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_admin'  =>  'boolean',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'user_id');
    }
}
