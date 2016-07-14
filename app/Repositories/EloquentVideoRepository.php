<?php

namespace App\Repositories;

use App\Video;
use App\Repositories\VideoRepository;

class EloquentVideoRepository implements VideoRepository
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
        return $this->video->latest->with('user')->latest()->paginate(15);
    }


    public function getLatestVideos()
    {
        return $this->video->with('user')->latest()->get();
    }
}
