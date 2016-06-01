<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tag;
use App\Post;
use View;
use DB;

class TagController extends Controller
{
    public function show($slug)
    {
        $data = [
            'posts' =>  Post::getInstance()->getPostsByTag($slug),
            'tags'          =>  Tag::all(),
            //'randposts'     =>  $randposts,
            'title' =>  Tag::getInstance()->getBySlug($slug)->tag,
            'app_name'      =>  'https://intospace.in.ua/',
            'counttags'     =>  Tag::join('post_tag', 'tags.id', '=', 'post_tag.tag_id')
                                    ->groupBy('tags.id')
                                    ->select(['tags.*', DB::raw('COUNT(*) as cnt')])
                                    ->orderBy('cnt', 'desc')
                                    ->get(),
        ];
        return View::make('frontend.main', $data);
    }
}
