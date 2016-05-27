<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\Video;
use Carbon\Carbon;
use Flash;
use App\Http\Requests;
use Redirect;
use Auth;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        return View::make('backend.videos.index', compact('videos'));
    }

    public function create()
    {
        $data = [
            'save_url'  =>  route('backend.videos.store'),
            'title' =>  'New video',
        ];
        return View::make('backend.videos.video', $data);
    }

    public function store(Request $request)
    {
        $video = $this->storeOrUpdateVideo($request, null);

        $video->save();

        return Redirect::route('backend.videos.edit', ['video_id' => $video->id]);
        //return Redirect::back();
    }

    public function edit($video_id)
    {
        $video = Video::find($video_id);

        return View::make('backend.videos.edit', compact('video'));
    }

    public function update(Request $request, $video_id)
    {
        $video = $this->storeOrUpdateVideo($request, $video_id);
        $video->resluggify();
        $video->update();

        return Redirect::back();
    }

    public function storeOrUpdateVideo(Request $request, $video_id)
    {
        $video = Video::findOrNew($video_id);
        $video->title = $request->input('title');
        $video->excerpt = $request->input('excerpt');
        $video->video = $request->input('video');
        $video->published_at = Carbon::now();

        return $video;
    }
}
