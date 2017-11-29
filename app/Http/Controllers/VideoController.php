<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Video;

/**
 * Class VideoController
 *
 * @package App\Http\Controllers
 */
class VideoController extends Controller
{
    protected $_video;

    /**
     * VideoController constructor.
     * @param Video $video
     */
    public function __construct(Video $video)
    {
        $this->_video = $video;
    }

    /**
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($slug='')
    {
        $videos = $this->_video->with('user')->groupBy('id')->orderBy('id', 'desc')->paginate(10);
        //dd($videos);

        return view('frontend.videos.index', compact('videos'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
