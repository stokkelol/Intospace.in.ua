<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Review;
use App\Band;
use Auth;
use Carbon\Carbon;
use App\Http\Requests\StoreReviewRequest;

class ReviewController extends Controller
{
    protected $_review;
    protected $_band;

    public function __construct(Review $review, Band $band)
    {
        $this->_review = $review;
        $this->_band = $band;
    }

    public function index()
    {
        $reviews = $this->_review->latest()->get();

        return view('backend.reviews.index', compact('reviews'));
    }

    public function show(Request $request, $id)
    {
        $review = $this->_review->findOrFail($id);

        return view('backend.reviews.show', compact('review'));
    }

    public function create()
    {
        $data = [
            'bands'         =>  $this->_band->all(),
            'save_url'      =>  route('backend.reviews.store'),
        ];
        return view('backend.reviews.review', $data);
    }

    public function destroy($id)
    {
        $review = $this->_review->findOrFail($id);

    }

    public function update(StoreReviewRequest $request, $id)
    {
        $review = $this->_review->findOrNew($id);
    }

    public function store(StoreReviewRequest $request)
    {
        $review = $this->storeOrUpdateReview($request, $review_id = null);

        if($request->hasFile('img')) {
            $image = $request->file('img');
            $this->saveImage($image);
            $review->img = $image->getClientOriginalName();
            $review->img_thumbnail = 'thumbnail_'.$image->getClientOriginalName();
        }

        $review->published_at = $request->input('published_at');
        $review->save();

        Flash::message('review created!');
        return redirect()->route('backend.reviews.edit', ['review_id' => $review->id]);
    }

    public function edit($review_id)
    {
        $data = [
            'review'          =>  $this->_review->find($review_id),
            'bands'         =>  $this->_band->all(),
        ];

        return view('backend.reviews.edit', $data);
    }

    public function storeOrUpdateReview(Request $request, $review_id)
    {
        $review = $this->_review->findOrNew($review_id);
        $review->user_id = Auth::user()->id;
        $review->title = $request->input('title');
        $review->band_id = $request->input('band_id');
        $review->content = $request->input('content');
        $review->video = $request->input('video');

        return $review;
    }

    public function saveImage($image)
    {
        $filename = $image->getClientOriginalName();
        $path = public_path('upload/covers/' . $filename);
        Image::make($image->getRealPath())->save($path);

        $filename2 = 'thumbnail_'.$image->getClientOriginalName();
        $path2 = public_path('upload/covers/' . $filename2);
        Image::make($image->getRealPath())->resize(300,300)->save($path2);
    }
}
