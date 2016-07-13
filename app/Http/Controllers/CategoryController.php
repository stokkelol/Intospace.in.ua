<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PostRepositoryInterface;
use App\Http\Requests;
use App\Category;
use App\Tag;

class CategoryController extends Controller
{
    protected $_category;
    protected $_post;
    protected $_tag;

    public function __construct(Category $category, PostRepositoryInterface $post, Tag $tag)
    {
        $this->_category = $category;
        $this->_post = $post;
        $this->_tag = $tag;
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
