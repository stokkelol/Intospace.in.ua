<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
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

        if($request->hasFile('img')) {
            $image = $request->file('img');
            $this->saveImage($image);
            $video->img = $image->getClientOriginalName();
        }

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

        if($request->hasFile('img')) {
            $image = $request->file('img');
            $this->saveImage($image);
            //dd($image);
            $video->img = $image->getClientOriginalName();
        }

        $video->resluggify();
        //dd($video->band_id);
        $video->update();

        Flash::message('Video updated!');
        return redirect()->route('backend.videos.edit', ['video_id' => $video->id]);
    }

    public function storeOrUpdateVideo(Request $request, $video_id)
    {
        $video = $this->_video->findOrNew($video_id);
        $video->user_id = Auth::user()->id;
        $video->title = $request->input('title');
        $video->band_id = $request->input('band_id');
        $video->excerpt = $request->input('excerpt');
        $video->video = $request->input('video');
        $video->published_at = $request->input('published_at');

        return $video;
    }

    public function saveImage($image)
    {
        $filename = $image->getClientOriginalName();
        $path = public_path('upload/covers/' . $filename);
        Image::make($image->getRealPath())->save($path);
    }
}
