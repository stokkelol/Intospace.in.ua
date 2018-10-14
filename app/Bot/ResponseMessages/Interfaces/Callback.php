<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\Interfaces;

/**
 * Interface Callback
 *
 * @package app\Bot\ResponseMessages\Interfaces
 */
interface Callback
{
    /**
     * @return string
     */
    public function prepare(): string;
}