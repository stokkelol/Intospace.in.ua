<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Models\Post;
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
     * BaseCommand constructor.
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->post = new PostRepository(new Post());
        $this->video = new VideoRepository(new Video());
        $this->type = $type;
    }
}