<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Entity;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * Class Blog
 *
 * @package App
 */
class Blog extends Entity
{
    use Sluggable;

    /**
     * @var string
     */
    protected $table = 'blogposts';

    /**
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
