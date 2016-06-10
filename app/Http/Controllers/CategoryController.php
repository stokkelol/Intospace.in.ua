<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\Post;
use App\Tag;

class CategoryController extends Controller
{
    protected $_category;
    protected $_post;
    protected $_tag;

    public function __construct(Category $_category, Post $_post, Tag $_tag)
    {

    }

    public function show($slug)
    {
        $data = [
            'posts' =>  $this->_post->getPostsByCategory($slug),
            'tags'  =>  $this->_tag->all(),
            'title' =>  $this->_category->getBySlug($slug)->title,
        ];

        return view('frontend.main', $data);
    }
}
