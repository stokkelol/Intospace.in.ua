<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class MonthlyReview extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $fillable = [
        'title', 'content', 'published_at'
    ];

    protected $sluggable = [
        'build_from'    =>  'title',
        'save_to'       =>  'slug',
        'unique'        =>  true,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
