<?php

namespace App\Http\Controllers;

use App\Http\Requests;

class PageController extends Controller
{
    public function index($page_title)
    {
        return view('frontend.pages.'.$page_title);
    }
}
