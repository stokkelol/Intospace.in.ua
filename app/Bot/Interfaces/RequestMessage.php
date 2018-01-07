<?php
declare(strict_types=1);

namespace App\Bot\Interfaces;

/**
 * Interface RequestMessage
 *
 * @package app\Bot\Interfaces
 */
interface RequestMessage
{
    /**
     * @return mixed
     */
    public function processRequest();

    /**
     * @return mixed
     */
    public function determineType();
}