<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages;

use App\Models\BotCommand;
use App\Models\Post;
use App\Repositories\Posts\PostRepository;

/**
 * Class CommandResponse
 *
 * @package App\Bot\ResponseMessages
 */
class CommandResponse extends Response
{
    const ENDPOINT = 'https://www.intospace.in.ua/posts/';

    public function createResponse()
    {
        $this->determineCommand();
    }

    /**
     * @return mixed
     */
    protected function extractType()
    {
        return $this->request['message']['text'];
    }

    /**
     * @return string
     */
    private function determineCommand()
    {
        $type = $this->extractType();

        if ($type == BotCommand::LATEST) {
            $this->sendLatestPosts();
        }

        if ($type == BotCommand::BLACK_METAL) {
            $this->sendBlackMetal();
        }
    }

    private function sendLatestPosts()
    {
        $posts = (new PostRepository(new Post()))->getLatestActivePosts(5);

        foreach ($posts as $post) {
            $this->responseMessage = static::ENDPOINT . $post->slug;
        }
    }

    private function sendBlackMetal()
    {
        $post = Post::query()->whereHas('tags', function ($query) {
            $query->where('tag', 'black metal');
        })->inRandomOrder()->first();

        $this->responseMessage = static::ENDPOINT . $post->slug;
    }
}