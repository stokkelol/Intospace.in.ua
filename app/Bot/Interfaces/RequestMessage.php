<?php
declare(strict_types=1);

namespace app\Bot\Interfaces;

/**
 * Interface RequestMessage
 *
 * @package app\Bot\Interfaces
 */
interface RequestMessage
{
    public function processRequest();

    public function determineType();
}