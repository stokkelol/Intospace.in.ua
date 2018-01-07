<?php
declare(strict_types=1);

namespace App\ApiConnection\Interfaces;

use GuzzleHttp\Client;

/**
 * Interface Connector
 *
 * @package app\ApiConnection\Interfaces
 */
interface Connector
{
    public function getClient(): Client;
}