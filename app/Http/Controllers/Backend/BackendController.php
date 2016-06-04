<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use App\Category;
use Auth;
use View;
use DB;
use App\Http\Requests;
use LaravelAnalytics;

class BackendController extends Controller
{
    /**
     * Dashboard controller
     *
     * @return mixed
     */
    public function index()
    {

        $data = [
            'title' =>  'Dashboard',
            'posts_total'       =>  Post::count(),
            'posts_active'      =>  Post::where('status', 'active')->count(),
            'posts_draft'       =>  Post::where('status', 'draft')->count(),
            'posts_moderation'  =>  Post::where('status', 'moderation')->count(),
            'users_total'       =>  User::count(),
            'recent_posts'      =>  Post::latest()->take(5)->get(),
            'popular_posts'     =>  Post::latest()->groupBy('views')->orderBy('views')->take(5)->get(),
            //'analyticsData'     =>  LaravelAnalytics::getVisitorsAndPageViews(7),
            //'users_active'      =>  User::where('active', '1')->count(),
            //'users_inactive'    =>  User::where('active', '0')->count(),
            //'latest_posts'      =>  Post::active()->orderBy('published_at', 'desc')->limit(5)->get(),
            //'popular_posts'     =>  Post::active()->orderBy('views', 'desc')->limit(5)->get(),


        ];
        //dd($data);

        return View::make('backend.main', $data);
    }
}
