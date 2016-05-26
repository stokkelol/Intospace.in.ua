<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\Post;
use App\Tag;
use View;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $data = [
            'posts' =>  Post::getInstance()->getPostsByCategory($slug),
            'tags'  =>  Tag::all(),
            'title' =>  Category::getInstance()->getBySlug($slug)->title,
        ];

        return View::make('frontend.main', $data);
    }
}
