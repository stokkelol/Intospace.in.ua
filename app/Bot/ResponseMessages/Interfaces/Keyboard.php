<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\Interfaces;

/**
 * Interface Keyboard
 *
 * @package App\Bot\ResponseMessages\Interfaces
 */
interface Keyboard
{
    public function prepare(array $response): array;
}