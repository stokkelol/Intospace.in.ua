<?php

namespace App\Support\Presenters;

use App\MonthlyReview;

class ReviewPresenter
{
    public $titles = [];
    public $contents = [];
    public $imgs = [];

    public function __construct($titles, $contents, $imgs)
    {
        $this->titles = $titles;
        $this->contents = $contents;
        $this->imgs = $imgs;
    }

    public function merge()
    {
        return collect($this->contents, $this->titles, $this->imgs);
    }
}
