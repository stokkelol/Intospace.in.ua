<?php
declare(strict_types=1);

namespace app\Bot\Interfaces;

/**
 * Interface ResponseMessage
 *
 * @package app\Bot\Interfaces
 */
interface ResponseMessage
{
    public function determineType();

    public function prepare();

    public function send();
}