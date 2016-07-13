<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Video extends Entity implements SluggableInterface
{
    use SluggableTrait;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function band()
    {
        return $this->belongsTo(Band::class, 'band_id');
    }

    public function getBySlug($slug)
    {
        return $this->with(['user'])->where('slug', $slug)->first();
    }
}
