<?php
declare(strict_types=1);

namespace App\Bot\Bands;

use App\Models\Band;

/**
 * Class Info
 *
 * @package App\Bot\Bands
 */
class Info
{
    /**
     * @var Band
     */
    private $band;

    /**
     * Info constructor.
     *
     * @param Band $band
     */
    public function __construct(Band $band)
    {
        $this->band = $band;
    }

    public function handle()
    {
        
    }
}