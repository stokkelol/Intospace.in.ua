<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Review;
use App\Http\Requests;

class ReviewController extends Controller
{
    protected $_review;

    public function __construct(Review $review)
    {
        $this->_review = $review;
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

    public function destroy($id)
    {
        $review = $this->_review->findOrFail($id);

    }

    public function update(Request $request, $id)
    {
        $review = $this->_review->findOrNew($id);
    }
}
