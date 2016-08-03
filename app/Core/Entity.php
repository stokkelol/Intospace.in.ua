<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Model;

abstract class Entity extends Model
{
    protected $fillable = [
        'id',
        'title',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'published_at'
    ];

    protected $sluggable = [
        'build_from'    =>  'title',
        'save_to'       =>  'slug',
        'unique'        =>   true,
    ];
}
