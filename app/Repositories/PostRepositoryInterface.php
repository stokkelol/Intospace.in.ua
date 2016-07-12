<?php

namespace App\Repositories;

interface PostRepositoryInterface
{
    public function getAllPosts();
    public function getLatestPublishedPosts();
}
