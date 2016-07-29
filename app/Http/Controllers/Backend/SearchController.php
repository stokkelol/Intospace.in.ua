<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Post;
use App\Category;
use Input;

class SearchController extends Controller
{
    public function index()
    {
        if (Input::has('search'))
        {
            $query = Input::get('search');
            $posts = Post::where('title','like','%'.$query.'%')->orderBy('id','ASC')->get();
            if ($posts->count() > 0) {
                $data = [
                    'posts'         =>  $posts,
                    'title'         =>  'Posts',
                    'categories'    =>  Category::all(),
                ];
            }
        }

        return view('backend.posts.index', $data);
    }
}
