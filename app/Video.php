<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Video extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'title',
        'save_to' => 'slug',
        'unique' => true,
    ];

    protected $dates = [
        'published_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getBySlug($slug)
    {
        return $this->with(['user'])->where('slug', $slug)->first();
    }

    public function getLatestVideos()
    {
        return Video::latest()
            ->take(10)
            ->get();
    }
}
