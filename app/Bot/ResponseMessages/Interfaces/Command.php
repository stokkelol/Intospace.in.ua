<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\Interfaces;

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
}