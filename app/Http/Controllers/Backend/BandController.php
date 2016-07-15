<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Band;
use App\Post;
use DB;
use Flash;

use App\Http\Requests;

class BandController extends Controller
{
    protected $_band;

    public function __construct(Band $band)
    {
        $this->_band = $band;
    }

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $bands = $this->_band->bySearch($request->get('search'))->paginate(15);
        } else {
        $bands = $this->_band->with('posts', 'videos')
                             ->orderBy('created_at', 'desc')
                             ->paginate(15);
        }

        return view('backend.bands.index', compact('bands'));
    }

    public function create()
    {
        $data =[
            'title'     =>  'Create New Band',
            'save_url'  =>  route('backend.bands.store'),
        ];

        return view('backend.bands.band', $data);
    }

    public function store(Request $request, $band_id = null)
    {
        $band = $this->_band->findOrNew($band_id);
        $band->title = $request->input('title');
        $band->save();
        Flash::message('Band created!');

        return redirect()->route('backend.bands.index');
    }

    public function edit($band_id)
    {
        $data = [
            'band' => $this->_band->find($band_id),
        ];

        return view('backend.bands.edit', $data);
    }

    public function update(Request $request, $band_id)
    {
        $band = $this->_band->findOrNew($band_id);
        $band->title = $request->input('title');
        $band->resluggify();
        $band->update();
        Flash::message('Band updated!');

        return redirect()->route('backend.bands.index');
    }

    public function show($band_id)
    {
        $band = $this->_band->findOrFail($band_id);

        return view('backend.bands.show', compact('band'));
    }
}
