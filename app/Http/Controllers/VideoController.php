<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Video;
use Illuminate\View\View;

/**
 * Class VideoController
 *
 * @package App\Http\Controllers
 */
class VideoController extends Controller
{
    /**
     * @var Video
     */
    protected $video;

    /**
     * VideoController constructor.
     * @param Video $video
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \InvalidArgumentException
     */
    public function index($slug=''): View
    {
        $videos = $this->video->with('user')
            ->groupBy('id')->orderBy('id', 'desc')->paginate(10);

        return view('frontend.videos.index', compact('videos'));
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function video($slug): View
    {
        $video = $this->video->getBySlug($slug);

        $data = [
            'video' => $video,
            'title' => $video->title,
            'app_name' => 'https://intospace.in.ua/'
        ];

        return view('frontend.videos.video', $data);
    }
}
