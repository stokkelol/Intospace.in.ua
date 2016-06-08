<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use App\Traits\InstanceTrait;

/**
 * App\Video
 *
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Video whereSlug($slug)
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $excerpt
 * @property string $video
 * @property string $slug
 * @property \Carbon\Carbon $published_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Video whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Video whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Video whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Video whereExcerpt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Video whereVideo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Video wherePublishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Video whereUpdatedAt($value)
 */
class Video extends Model implements SluggableInterface
{
    use SluggableTrait;
    use InstanceTrait;

    /**
     * Sluggable
     *
     * @var array
     */
    protected $sluggable = [
        'build_from' => 'title',
        'save_to' => 'slug',
        'unique' => true,
    ];

    protected $dates = [
        'published_at',
    ];

    public static $instance = null;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getBySlug($slug)
    {
        return $this->with(['user'])->where('slug', $slug)->first();
    }
}
