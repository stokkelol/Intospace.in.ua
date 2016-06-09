<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\Post;
use App\Tag;

class CategoryController extends Controller
{
    public function show(Category $_category, Post $_post, Tag $_tag, $slug)
    {
        $data = [
            'posts' =>  $_post->getPostsByCategory($slug),
            'tags'  =>  $_tag->all(),
            'title' =>  $_category->getBySlug($slug)->title,
        ];

        return view('frontend.main', $data);
    }
}
