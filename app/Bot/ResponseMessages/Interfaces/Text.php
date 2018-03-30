<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\Interfaces;

use App\Models\Band;

/**
 * Interface Text
 *
 * @package app\Bot\ResponseMessages\Interfaces
 */
interface Text
{
    /**
     * @return array
     */
    public function prepare(): array;

    /**
     * @return Band
     */
    public function getBand(): Band;
}