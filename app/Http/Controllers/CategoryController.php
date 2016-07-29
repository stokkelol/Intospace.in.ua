<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Posts\PostRepository;
use App\Http\Requests;
use App\Category;
use App\Tag;

class CategoryController extends Controller
{
    protected $category;
    protected $post;
    protected $tag;

    public function __construct(Category $category,
                                PostRepository $post,
                                Tag $tag)
    {
        $this->category = $category;
        $this->post = $post;
        $this->tag = $tag;
    }

    public function show($slug)
    {
        $data = [
            'posts' =>  $this->post->getPostsByCategory($slug)->paginate(15),
            'tags'  =>  $this->tag->all(),
            'title' =>  $this->category->getBySlug($slug)->title,
        ];

        //dd($data);

        return view('frontend.main', $data);
    }
}
