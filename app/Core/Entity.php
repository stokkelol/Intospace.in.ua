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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
