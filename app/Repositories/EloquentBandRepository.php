<?php

namespace App\Repositories;

use App\Band;

class EloquentBandRepository implements BandRepository
{
    protected $band;

    public function __construct(Band $band)
    {
        $this->band = $band;
    }

    public function getAllBands()
    {
        return $this->band->with('posts', 'videos')->orderBy('title', 'asc')->get();
    }

    public function getAllBandsBySearch($query)
    {
        return $this->band->with('posts', 'videos')->where('title', 'like', '%'.$query.'%')->orderBy('title', 'asc')->get();
    }
}
