<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\Interfaces;

use App\Models\Album;
use App\Models\Band;
use App\Models\Track;

/**
 * Interface Command
 *
 * @package app\Bot\ResponseMessages\Interfaces
 */
interface Command
{
    /**
     * @return array
     */
    public function prepare(): array;

    /**
     * @return Band
     */
    public function getBand(): Band;

    /**
     * @return Album
     */
    public function getAlbum(): Album;

    /**
     * @return Track
     */
    public function getTrack(): Track;
}