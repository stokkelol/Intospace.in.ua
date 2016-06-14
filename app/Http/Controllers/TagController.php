<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Tag;
use App\Post;

class TagController extends Controller
{
    protected $_tag;
    protected $_post;

    public function __construct(Tag $tag, Post $post)
    {
        $this->_tag = $tag;
        $this->_post = $post;
    }

    public function show($slug)
    {
        $data = [
            'posts'           =>  $this->_post->getPostsByTag($slug),
            'tags'            =>  $this->_tag->all(),
            'title'           =>  $this->_tag->findBySlug($slug)->tag
        ];
        return view('frontend.main', $data);
    }
}
