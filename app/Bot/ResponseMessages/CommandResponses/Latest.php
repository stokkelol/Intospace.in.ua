<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Models\Post;
use App\Repositories\Posts\PostRepository;

/**
 * Class Latest
 *
 * @package app\Bot\ResponseMessages\CommandResponses
 */
class Latest
{
    const ENDPOINT = 'https://www.intospace.in.ua/posts/';

    public function prepare()
    {
        $posts = (new PostRepository(new Post()))->getLatestActivePosts(5);

        foreach ($posts as $post) {
            $result[] = static::ENDPOINT . $post->slug;
        }

        return $result;
    }
}