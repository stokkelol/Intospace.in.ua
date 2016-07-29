<?php

namespace App\Repositories\Videos;

interface VideoRepository
{
    public function getAllVideos();
    public function getLatestPublishedVideos();
}
