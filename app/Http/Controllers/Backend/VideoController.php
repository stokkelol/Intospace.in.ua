<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Video;
use Carbon\Carbon;
use Flash;
use App\Http\Requests;
use Auth;

class VideoController extends Controller
{
    protected $_video;

    public function __construct(Video $video)
    {
        $this->_video = $video;
    }

    public function index()
    {
        $videos = $this->_video->orderBy('id', 'desc')->paginate(15);

        return view('backend.videos.index', compact('videos'));
    }

    public function create()
    {
        $data = [
            'save_url'  =>  route('backend.videos.store'),
            'title' =>  'New video',
        ];
        return view('backend.videos.video', $data);
    }

    public function store(Request $request)
    {
        $video = $this->storeOrUpdateVideo($request, null);

        $video->save();
        //dd($video);
        Flash::message('Video created!');
        return redirect()->route('backend.videos.edit', ['video_id' => $video->id]);
        //return Redirect::back();
    }

    public function edit($video_id)
    {
        $video = $this->_video->find($video_id);

        return view('backend.videos.edit', compact('video'));
    }

    public function update(Request $request, $video_id)
    {
        $video = $this->storeOrUpdateVideo($request, $video_id);
        $video->resluggify();
        $video->update();

        Flash::message('Video updated!');
        return redirect()->route('backend.videos.edit', ['video_id' => $video->id]);
    }

    public function storeOrUpdateVideo(Request $request, $video_id)
    {
        $video = $this->_video->findOrNew($video_id);
        $video->title = $request->input('title');
        $video->excerpt = $request->input('excerpt');
        $video->video = $request->input('video');
        $video->published_at = Carbon::now();

        return $video;
    }
}
