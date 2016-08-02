<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MonthlyReviews\MonthlyReviewRepository;
use App\Http\Requests;

class MonthlyReviewController extends Controller
{
    protected $review;

    public function __construct(MonthlyReviewRepository $review)
    {
        $this->review = $review;
    }

    public function index()
    {
        $reviews = $this->review->getAllReviews();

        //dd($reviews);
        return view('frontend.monthlyreviews.index', compact('reviews'));
    }

    public function show($slug)
    {
        $review = $this->review->getReviewBySlug($slug);

        return view('frontend.monthlyreviews.show', $review);
    }
}
