<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Class PageController
 *
 * @package App\Http\Controllers
 */
class PageController extends Controller
{
    /**
     * @param $page_title
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($page_title): View
    {
        return view('frontend.pages.'.$page_title);
    }
}
