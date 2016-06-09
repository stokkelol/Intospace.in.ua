<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Tag;
use App\Post;

class TagController extends Controller
{
    public function show(Tag $_tag, Post $_post, $slug)
    {
        $data = [
            'posts'           =>  $_post->getPostsByTag($slug),
            'tags'            =>  $_tag->all(),
            'title'           =>  $_tag->getBySlug($slug)->tag,
            'app_name'        =>  'https://intospace.in.ua/',
        ];
        return view('frontend.main', $data);
    }
}
