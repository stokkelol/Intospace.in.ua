<?php
declare(strict_types=1);

namespace App\Support\Presenters;

use Illuminate\Support\Collection;

/**
 * Class ReviewPresenter
 *
 * @package App\Support\Presenters
 */
class ReviewPresenter
{
    /**
     * @var array
     */
    public $titles = [];

    /**
     * @var array
     */
    public $contents = [];

    /**
     * @var array
     */
    public $imgs = [];

    /**
     * ReviewPresenter constructor.
     *
     * @param $titles
     * @param $contents
     * @param $imgs
     */
    public function __construct($titles, $contents, $imgs)
    {
        $this->titles = $titles;
        $this->contents = $contents;
        $this->imgs = $imgs;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function merge(): Collection
    {
        return collect($this->contents, $this->titles, $this->imgs);
    }
}
