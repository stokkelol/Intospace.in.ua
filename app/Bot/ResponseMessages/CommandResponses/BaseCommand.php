<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Models\Band;
use App\Models\Post;
use App\Models\TelegramUser;
use App\Models\Video;

/**
 * Class BaseCommand
 *
 * @package app\Bot\ResponseMessages\CommandResponses
 */
abstract class BaseCommand
{
    const POSTS_ENDPOINT = 'https://www.intospace.in.ua/posts/';
    const YOUTUBE_ENDPOINT  = 'https://www.yputube.com/watch?v=';

    /**
     * @var Post
     */
    protected $post;

    /**
     * @var Video
     */
    protected $video;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var TelegramUser
     */
    protected $user;

    /**
     * @var Band
     */
    protected $band;

    /**
     * @var array
     */
    protected $context = [
        'band' => null,
        'album' => null,
        'track' => null
    ];

    /**
     * BaseCommand constructor.
     *
     * @param string $type
     * @param TelegramUser $user
     */
    public function __construct(string $type, TelegramUser $user)
    {
        $this->setPrimaryDependencies();
        $this->type = $type;
        $this->user = $user;
    }

    /**
     * @return void
     */
    private function setPrimaryDependencies(): void
    {
        $this->post = new Post();
        $this->video = new Video();
    }

    /**
     * @return bool
     */
    public function isContextAvailable(): bool
    {
        $res = false;

        \array_walk($this->context, function ($value) use (&$res) {
            if ($value !== null) {
                $res = true;
            }
        });

        return $res;
    }
}