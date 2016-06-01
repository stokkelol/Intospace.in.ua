<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use View;

class PageController extends Controller
{
    public function index($page_title)
    {
        return View::make('frontend.pages.'.$page_title);
    }
}
