<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Video;
use View;

class VideoController extends Controller
{
    public function index($slug='')
    {
        $videos = Video::with('user')->groupBy('id')->orderBy('id', 'desc')->paginate(10);
        //dd($videos);
        
        return View::make('frontend.videos.index', compact('videos'));
    }

    public function video($slug)
    {
        $video = Video::getInstance()->getBySlug($slug);

        $data = [
            'video'     =>  $video,
            'title'     =>  $video->title,
            'app_name'  =>  'https://intospace.in.ua/'
        ];

        //dd($video);

        return View::make('frontend.videos.video', $data);
    }
}
