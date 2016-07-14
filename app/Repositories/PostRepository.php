<?php

namespace App\Repositories;

interface PostRepository
{
    public function getAllPosts();
    public function getLatestPublishedPosts();
}
