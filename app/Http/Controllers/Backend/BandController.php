<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Band;
use App\Repositories\Bands\BandRepository;
use App\Post;
use DB;
use Flash;

use App\Http\Requests;

class BandController extends Controller
{
    protected $band;
    protected $bandRepository;

    public function __construct(Band $band, BandRepository $bandRepository)
    {
        $this->band = $band;
        $this->bandRepository = $bandRepository;
    }

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $bands = $this->bandRepository->getAllBandsBySearch($request->get('search'))->paginate(15);
        } else {
        $bands = $this->bandRepository->getAllBands()->paginate(15);
        }

        return view('backend.bands.index', compact('bands'));
    }

    public function create()
    {
        $data =[
            'title'     =>  'Create New Band',
            'save_url'  =>  route('backend.bands.store'),
        ];

        return view('backend.bands.create', $data);
    }

    public function store(Request $request, $band_id = null)
    {
        $band = $this->band->findOrNew($band_id);
        $band->title = $request->input('title');
        $band->save();
        Flash::message('Band created!');

        return redirect()->route('backend.bands.index');
    }

    public function edit($band_id)
    {
        $data = [
            'band' => $this->band->find($band_id),
        ];

        return view('backend.bands.edit', $data);
    }

    public function update(Request $request, $band_id)
    {
        $band = $this->band->findOrNew($band_id);
        $band->title = $request->input('title');
        $band->resluggify();
        $band->update();
        Flash::message('Band updated!');

        return redirect()->route('backend.bands.index');
    }

    public function show($band_id)
    {
        $band = $this->band->findOrFail($band_id);

        return view('backend.bands.show', compact('band'));
    }
}
