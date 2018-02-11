<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Models\Post;
use App\Models\TelegramUser;
use App\Models\Video;
use App\Repositories\Posts\PostRepository;
use App\Repositories\Videos\VideoRepository;

/**
 * Class BaseCommand
 *
 * @package app\Bot\ResponseMessages\CommandResponses
 */
abstract class BaseCommand
{
    const POSTS_ENDPOINT = 'https://www.intospace.in.ua/posts/';

    /**
     * @var PostRepository
     */
    protected $post;

    /**
     * @var VideoRepository
     */
    protected $video;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var StatisticGatherer
     */
    protected $gatherer;

    /**
     * @var TelegramUser
     */
    protected $user;

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
        $this->post = new PostRepository(new Post());
        $this->video = new VideoRepository(new Video());
        $this->gatherer = new StatisticGatherer();
    }
}