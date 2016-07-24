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

    public function getVideosBySearchQuery($query)
    {
        $videos = $this->video->with('user')
                ->where('title', 'like', '%'.$query.'%')
                ->groupBy('published_at')
                ->orderBy('published_at', 'desc');

        return $videos;
    }

    public function getVideosByBandSlug($slug)
    {
        $videos = $this->video->whereHas('band', function ($query) use ($slug) {
                                                  $query->whereSlug($slug);})
                                                ->latest();

        return $videos;
    }
}
