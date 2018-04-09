<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\Interfaces;

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
}