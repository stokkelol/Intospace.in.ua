<?php

namespace App\Repositories\Posts;

interface PostRepository
{
    public function getAllPosts();
    public function getLatestPublishedPosts();
}
