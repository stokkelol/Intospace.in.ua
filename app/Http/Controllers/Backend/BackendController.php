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
    /**
     * Dashboard controller
     *
     * @return mixed
     */
    public function index(Post $_post, Video $_video, User $_user)
    {

        $data = [
            'title' =>  'Dashboard',
            'posts_total'       =>  $_post->count(),
            'posts_active'      =>  $_post->where('status', 'active')->count(),
            'posts_draft'       =>  $_post->where('status', 'draft')->count(),
            'posts_moderation'  =>  $_post->where('status', 'moderation')->count(),
            'videos_total'       =>  $_video->count(),
            'users_total'       =>  $_user->count(),
            'recent_posts'      =>  $_post->latest()->take(5)->get(),
            'popular_posts'     =>  $_post->latest()->groupBy('views')->orderBy('views')->take(5)->get(),
            //'analyticsData'     =>  LaravelAnalytics::getVisitorsAndPageViews(7),
            //'users_active'      =>  User::where('active', '1')->count(),
            //'users_inactive'    =>  User::where('active', '0')->count(),
            //'latest_posts'      =>  Post::active()->orderBy('published_at', 'desc')->limit(5)->get(),
            //'popular_posts'     =>  Post::active()->orderBy('views', 'desc')->limit(5)->get(),


        ];
        //dd($data);

        return view('backend.main', $data);
    }
}
