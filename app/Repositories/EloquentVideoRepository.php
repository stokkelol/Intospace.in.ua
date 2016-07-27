<?php

namespace App\Repositories;

use App\Video;
use App\Repositories\VideoRepository;
use App\Support\CustomCollections\CollectionByIds;

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
        return $this->video->with('user')->latest();
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

    public function getMonthlyVideos()
    {
        $videos = $this->video->getMonthlyItems()->orderBy('published_at', 'desc')->get();

        return $videos;
    }

    public function getVideosById($video_id)
    {
        $videos = new CollectionByIds($this->video);
        //dd($video_id);
        return $videos->find($video_id);
    }
}
