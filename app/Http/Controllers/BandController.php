<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Band;
use DB;

use App\Http\Requests;

class BandController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $query = $request->input('search');
            $bands = Band::with('posts', 'videos')->where('title', 'like', '%'.$query.'%')->orderBy('title', 'asc')->get();
        } else {
            $bands = Band::with('posts', 'videos')->orderBy('title', 'asc')->get();
        }

        return view('frontend.bands.index', compact('bands'));
    }
}
