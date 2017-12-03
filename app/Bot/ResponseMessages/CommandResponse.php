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

        return $this->send();
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
            $posts = (new PostRepository(new Post()))->getLatestActivePosts(5);

            foreach ($posts as $post) {
                $this->responseMessage = static::ENDPOINT . $post->slug;

                $this->send();
            }
        }
    }
}