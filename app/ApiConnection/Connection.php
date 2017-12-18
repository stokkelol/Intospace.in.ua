<?php
declare(strict_types=1);

namespace App\ApiConnection;

use app\ApiConnection\Interfaces\Connector;
use GuzzleHttp\Client;

/**
 * Class Connection
 *
 * @package App\ApiConnection
 */
class Connection implements Connector
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Connection constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }
    
    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }
}