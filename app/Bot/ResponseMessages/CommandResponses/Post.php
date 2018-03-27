<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;

/**
 * Class Post
 *
 * @package App\Bot\ResponseMessages\CommandResponses
 */
class Post extends BaseCommand implements Command
{
    /**
     * @return array
     * @throws \Exception
     */
    public function prepare(): array
    {
        /** @var Post $post */
        $post = \App\Models\Post::query()->inRandomOrder()->first();

        $this->band = $post->band;

        $gatherer = new StatisticGatherer($this->user);
        $gatherer->associateBandAndUser($this->band);
        $gatherer->associateTagAndUser($this->band);


        return [static::YOUTUBE_ENDPOINT . $post->video];
    }
}