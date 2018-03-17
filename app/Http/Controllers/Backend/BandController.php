<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Band;
use App\Repositories\Bands\BandRepository;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;

/**
 * Class BandController
 *
 * @package App\Http\Controllers\Backend
 */
class BandController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $bands = Band::query()->with('posts', 'videos')
                ->where('title', 'like', '%' . $request->get('search') . '%')
                ->orderBy('title')->paginate(15);
        } else {
            $bands = Band::query()->paginate(15);
        }

        return view('backend.bands.index', compact('bands'));
    }

    public function create()
    {
        $data =[
            'title' => 'Create New Band',
            'save_url' => route('backend.bands.store'),
        ];

        return view('backend.bands.create', $data);
    }

    public function store(Request $request, $band_id = null)
    {
        $band = Band::query()->findOrNew($band_id);
        $band->title = $request->input('title');
        $band->save();
        Flash::message('Band created!');

        return redirect()->route('backend.bands.index');
    }

    public function edit($band_id)
    {
        return view('backend.bands.edit', \compact(['band' => Band::query()->find($band_id)]));
    }

    public function update(Request $request, $band_id)
    {
        $band = Band::query()->findOrNew($band_id);
        $band->title = $request->input('title');
        $band->resluggify();
        $band->update();
        Flash::message('Band updated!');

        return redirect()->route('backend.bands.index');
    }

    public function show($band_id)
    {
        return view('backend.bands.show', \compact(['band' => Band::query()->findOrFail($band_id)]));
    }
}
