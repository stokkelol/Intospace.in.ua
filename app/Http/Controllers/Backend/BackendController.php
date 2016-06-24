<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use App\Category;
use Auth;
use DB;
use App\Video;
use App\Http\Requests;
use LaravelAnalytics;

class BackendController extends Controller
{
    protected $_post;
    protected $_video;
    protected $_user;

    public function __construct(Post $post, Video $video, User $user)
    {
        $this->_post = $post;
        $this->_video = $video;
        $this->_user = $user;
    }

    public function index()
    {

        $data = [
            'title' =>  'Dashboard',
            'posts_total'         =>  $this->_post->count(),
            'posts_active'        =>  $this->_post->where('status', 'active')->count(),
            'posts_draft'         =>  $this->_post->where('status', 'draft')->count(),
            'posts_moderation'    =>  $this->_post->where('status', 'moderation')->count(),
            'videos_total'        =>  $this->_video->count(),
            'users_total'         =>  $this->_user->count(),
            'recent_posts'        =>  $this->_post->latest()->take(5)->get(),
            'popular_posts'       =>  $this->_post->latest()->groupBy('views')->orderBy('views')->take(5)->get(),
            //'analyticsData'     =>  LaravelAnalytics::getVisitorsAndPageViews(7),
        ];
        //dd($data);

        return view('backend.main', $data);
    }
}
