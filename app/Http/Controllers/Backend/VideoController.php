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
    public function index(Video $_video)
    {
        $videos = $_video->orderBy('id', 'desc')->paginate(15);

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

    public function store(Video $_video, Request $request)
    {
        $video = $this->storeOrUpdateVideo($_video, $request, null);

        $video->save();

        Flash::message('Video created!');
        return redirect()->route('backend.videos.edit', ['video_id' => $video->id]);
        //return Redirect::back();
    }

    public function edit(Video $_video, $video_id)
    {
        $video = $_video->find($video_id);

        return view('backend.videos.edit', compact('video'));
    }

    public function update(Video $_video, Request $request, $video_id)
    {
        $video = $this->storeOrUpdateVideo($_video, $request, $video_id);
        $video->resluggify();
        $video->update();

        Flash::message('Video updated!');
        return redirect()->route('backend.videos.edit', ['video_id' => $video->id]);
    }

    public function storeOrUpdateVideo(Video $_video, Request $request, $video_id)
    {
        $video = $_video->findOrNew($video_id);
        $video->title = $request->input('title');
        $video->excerpt = $request->input('excerpt');
        $video->video = $request->input('video');
        $video->published_at = Carbon::now();

        return $video;
    }
}
