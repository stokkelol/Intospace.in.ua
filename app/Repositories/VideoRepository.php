<?php

namespace App\Repositories;

interface VideoRepository
{
    public function getAllVideos();
    public function getLatestPublishedVideos();
}
