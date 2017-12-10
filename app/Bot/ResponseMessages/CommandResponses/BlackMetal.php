<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use app\Bot\ResponseMessages\Interfaces\Command;
use App\Models\Post;

/**
 * Class BlackMetal
 *
 * @package app\Bot\ResponseMessages\CommandResponses
 */
class BlackMetal implements Command
{
    const ENDPOINT = 'https://www.intospace.in.ua/posts/';

    /**
     * @return array
     */
    public function prepare(): array
    {
        $post = Post::query()->whereHas('tags', function ($query) {
            $query->where('tag', 'black metal');
        })->inRandomOrder()->first();

        return [static::ENDPOINT . $post->slug];
    }
}