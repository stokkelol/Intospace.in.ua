<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tag;
use App\Post;
use View;

class TagController extends Controller
{
    public function show($slug)
    {
        $data = [
            'posts' =>  Post::getInstance()->getPostsByTag($slug),
            'tags'          =>  Tag::all(),
            //'randposts'     =>  $randposts,
            'title' =>  Tag::getInstance()->getBySlug($slug)->tag,
            'app_name'      =>  'https://intospace.in.ua/'
        ];
        return View::make('frontend.main', $data);
    }
}
