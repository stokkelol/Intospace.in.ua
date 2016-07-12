<?php

namespace App\Repositories;

use App\Video;
use App\Repositories\VideoRepositoryInterface;

class VideoRepository implements VideoRepositoryInterface
{
    protected $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    public function getAllVideos()
    {
        return $this->video->with('user')->groupBy('published_at')
        ->orderBy('published_at', 'desc')
        ->paginate(15);
    }

    public function getLatestPublishedVideos()
    {
        return $this->video->latest->with('user')->take(15)->get();
    }
}
