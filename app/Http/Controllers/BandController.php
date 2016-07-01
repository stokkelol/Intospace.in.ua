<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;

use App\Http\Requests;

class BandController extends Controller
{
    public function index()
    {

        $bands = DB::table('posts')->lists('band_title');

        //dd($bands);

        return view('frontend.bands.index', compact('bands'));
    }
}
