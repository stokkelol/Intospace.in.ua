<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Video;

class VideoController extends Controller
{
    protected $_video;

    public function __construct(Video $video)
    {
        $this->_video = $video;
    }

    public function index($slug='')
    {
        $videos = $this->_video->with('user')->groupBy('id')->orderBy('id', 'desc')->paginate(10);
        //dd($videos);

        return view('frontend.videos.index', compact('videos'));
    }

    public function video($slug)
    {
        $video = $this->_video->getBySlug($slug);

        $data = [
            'video'     =>  $video,
            'title'     =>  $video->title,
            'app_name'  =>  'https://intospace.in.ua/'
        ];

        //dd($video);

        return view('frontend.videos.video', $data);
    }
}
