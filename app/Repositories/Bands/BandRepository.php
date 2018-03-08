<?php
declare(strict_types=1);

namespace App\Repositories\Bands;

use App\Models\Band;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EloquentBandRepository
 *
 * @package App\Repositories\Bands
 */
class BandRepository
{
    /**
     * @var Band
     */
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
     * @return Builder
     */
    public function getAllBands(): Builder
    {
        return $this->band->with('posts', 'videos')
            ->where('is_post_exist', '=', true)->orderBy('title', 'asc');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function getAllBandsBySearch(Builder $query): Builder
    {
        return $this->band->with('posts', 'videos')
            ->where('title', 'like', '%' . $query . '%')
            ->orderBy('title', 'asc');
    }
}
