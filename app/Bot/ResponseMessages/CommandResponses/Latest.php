<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;

/**
 * Class Latest
 *
 * @package app\Bot\ResponseMessages\CommandResponses
 */
class Latest extends BaseCommand implements Command
{
    const POSTS_ENDPOINT = 'https://www.intospace.in.ua/posts/';

    /**
     * @return array
     */
    public function prepare(): array
    {
        $posts = $this->post->getLatestActivePosts(5);

        foreach ($posts as $post) {
            $result[] = static::POSTS_ENDPOINT . $post->slug;
        }

        return $result;
    }
}