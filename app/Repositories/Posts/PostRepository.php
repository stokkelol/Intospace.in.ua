<?php
declare(strict_types=1);

namespace App\Repositories\Posts;

/**
 * @method getActivePosts()
 *
 * Interface PostRepository
 *
 * @package App\Repositories\Posts
 */
interface PostRepository
{
    public function getAllPosts();
    public function getLatestPublishedPosts();
}
