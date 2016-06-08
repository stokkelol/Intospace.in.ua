<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\InstanceTrait;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{

    use InstanceTrait;
    use EntrustUserTrait;

    /**
     * Users table name
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_admin'  =>  'boolean',
    ];

    public static $instance = null;

    /**
     * User have many posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'user_id');
    }
}
