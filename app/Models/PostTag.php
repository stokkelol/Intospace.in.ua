<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PostTag
 *
 * @package App\Models
 */
class PostTag extends Model
{
    /**
     * @var string
     */
    protected $table = "post_tag";

    /**
     * @var array
     */
    protected $fillable = ['post_id', 'tag_id'];
}
