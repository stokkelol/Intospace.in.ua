<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Band;
use DB;

use App\Http\Requests;

class BandController extends Controller
{
    public function index()
    {

        $bands = Band::with('posts', 'reviews', 'videos')->get();

        //dd($bands);

        return view('frontend.bands.index', compact('bands'));
    }
}
