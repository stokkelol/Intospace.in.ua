<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use App\Video;
use Carbon;
use Flash;
use App\Http\Requests;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        return View::make('backend.videos.index', compact('videos'));
    }

    public function create()
    {
        return View::make('backend.videos.video');
    }

    public function store(Request $reqeust, $video_id)
    {
        $video = Video::findOrNew($video_id);
        $video->user_id = Auth::user()->id;
        $video->title = $request->input('title');
        $video->excerpt = $request->input('excerpt');
        $video->video = $request->input('video');
        $video->published_at = Carbon::now();

        return Redirect::route('backend.videos.edit', ['video_id' => $video_id]);
    }
}
