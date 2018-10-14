<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\Interfaces;

/**
 * Interface Button
 *
 * @package App\Bot\ResponseMessages\Interfaces
 */
interface Button
{
    /**
     * @return string
     */
    public function prepareTitle(): string;

    /**
     * @return array
     */
    public function prepareCallback(): array;
}