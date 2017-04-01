<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Tag;
use App\Models\Post;

/**
 * Class TagController
 * @package App\Http\Controllers
 */
class TagController extends Controller
{
    protected $tag;
    protected $post;

    /**
     * TagController constructor.
     * @param Tag $tag
     * @param Post $post
     */
    public function __construct(Tag $tag, Post $post)
    {
        $this->tag = $tag;
        $this->post = $post;
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $data = [
            'posts'           =>  $this->post->getPostsByTag($slug),
            'tags'            =>  $this->tag->all(),
            'title'           =>  $this->tag->findBySlug($slug)->tag
        ];
        return view('frontend.main', $data);
    }
}
