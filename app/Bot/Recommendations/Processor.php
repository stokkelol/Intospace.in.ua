<?php
declare(strict_types=1);

namespace App\Bot\Recommendations;

use App\Bot\Youtube\Youtube;

/**
 * Class Processor
 *
 * @package App\Bot\Recommendations
 */
class Processor
{
    /**
     * @var Youtube
     */
    private $client;

    /**
     * Processor constructor.
     *
     * @param Youtube $client
     */
    public function __construct(Youtube $client)
    {
        $this->client = $client;
    }
}