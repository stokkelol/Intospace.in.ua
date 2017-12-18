<?php
declare(strict_types=1);

namespace App\Core;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
 * Class Entity
 *
 * @package App\Core
 */
abstract class Entity extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'published_at'
    ];

    /**
     * @var array
     */
    protected $sluggable = [
        'build_from'    =>  'title',
        'save_to'       =>  'slug',
        'unique'        =>   true,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
