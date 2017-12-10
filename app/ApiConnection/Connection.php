<?php
declare(strict_types=1);

namespace app\ApiConnection;

use app\ApiConnection\Interfaces\Connector;
use GuzzleHttp\Client;

/**
 * Class Connection
 *
 * @package app\ApiConnection
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