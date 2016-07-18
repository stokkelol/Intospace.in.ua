<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Band;
use DB;
use App\Repositories\BandRepository;

use App\Http\Requests;

class BandController extends Controller
{
    protected $band;

    public function __construct(BandRepository $band)
    {
        $this->band = $band;
    }

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $bands = $this->band->getAllBandsBySearch($request->input('search'))->get();
            return view('frontend.bands.index', compact('bands'));
        }

        $bands = $this->band->getAllBands()->get();
        return view('frontend.bands.index', compact('bands'));
    }
}
