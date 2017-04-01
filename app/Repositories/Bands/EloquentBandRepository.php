<?php

namespace App\Repositories\Bands;

use App\Models\Band;
use App\Repositories\Bands\BandRepository;

/**
 * Class EloquentBandRepository
 * @package App\Repositories\Bands
 */
class EloquentBandRepository implements BandRepository
{
    protected $band;

    /**
     * EloquentBandRepository constructor.
     * @param Band $band
     */
    public function __construct(Band $band)
    {
        $this->band = $band;
    }

    /**
     * @return mixed
     */
    public function getAllBands()
    {
        return $this->band->with('posts', 'videos')->orderBy('title', 'asc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function getAllBandsBySearch($query)
    {
        return $this->band->with('posts', 'videos')
            ->where('title', 'like', '%' . $query . '%')
            ->orderBy('title', 'asc');
    }
}
