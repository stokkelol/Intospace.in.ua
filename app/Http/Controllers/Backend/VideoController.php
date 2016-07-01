<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Controllers\Controller;
use App\Video;
use Carbon\Carbon;
use Flash;
use Auth;
use App\Band;

class VideoController extends Controller
{
    protected $_video;
    protected $_band;

    public function __construct(Video $video, Band $band)
    {
        $this->_video = $video;
        $this->_band = $band;
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
            'title'     =>  'New video',
            'bands'     =>  $this->_band->all(),
        ];
        return view('backend.videos.video', $data);
    }

    public function store(StoreVideoRequest $request)
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
        $bands = $this->_band->all();

        return view('backend.videos.edit', compact('video', 'bands'));
    }

    public function update(StoreVideoRequest $request, $video_id)
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
        $video->band_id = $request->input('band_id');
        $video->excerpt = $request->input('excerpt');
        $video->video = $request->input('video');
        $video->published_at = Carbon::now();

        return $video;
    }
}
