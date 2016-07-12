<?php

namespace App\Repositories;

interface VideoRepositoryInterface
{
    public function getAllVideos();
    public function getLatestPublishedVideos();
}
