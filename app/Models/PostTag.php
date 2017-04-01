<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
