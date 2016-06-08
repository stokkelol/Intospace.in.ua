<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PostTag
 *
 * @mixin \Eloquent
 * @property integer $post_id
 * @property integer $tag_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\PostTag wherePostId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostTag whereTagId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PostTag whereUpdatedAt($value)
 */
class PostTag extends Model
{

    protected $table = "post_tag";
    protected $fillable = ['post_id', 'tag_id'];
    
}
