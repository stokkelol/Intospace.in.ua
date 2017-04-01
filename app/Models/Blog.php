<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use App\Core\Entity;

/**
 * Class Blog
 * @package App
 */
class Blog extends Entity implements SluggableInterface
{
    use SluggableTrait;
    
    /**
     * @var string
     */
    protected $table = 'blogposts';
}
