<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Video;

class VideoController extends Controller
{
    public function index(Video $_video, $slug='')
    {
        $videos = $_video->with('user')->groupBy('id')->orderBy('id', 'desc')->paginate(10);
        //dd($videos);
        
        return view('frontend.videos.index', compact('videos'));
    }

    public function video(Video $_video, $slug)
    {
        $video = $_video->getBySlug($slug);

        $data = [
            'video'     =>  $video,
            'title'     =>  $video->title,
            'app_name'  =>  'https://intospace.in.ua/'
        ];

        //dd($video);

        return view('frontend.videos.video', $data);
    }
}
