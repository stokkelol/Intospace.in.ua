<?php
declare(strict_types=1);

namespace app\Bot\ResponseMessages\CommandResponses;

use App\Models\Post;

/**
 * Class BlackMetal
 *
 * @package app\Bot\ResponseMessages\CommandResponses
 */
class BlackMetal
{
    const ENDPOINT = 'https://www.intospace.in.ua/posts/';

    public function prepare()
    {
        $post = Post::query()->whereHas('tags', function ($query) {
            $query->where('tag', 'black metal');
        })->inRandomOrder()->first();

        return [static::ENDPOINT . $post->slug];
    }
}