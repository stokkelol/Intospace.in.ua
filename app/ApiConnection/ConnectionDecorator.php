<?php
declare(strict_types=1);

namespace App\ApiConnection;

use App\ApiConnection\Interfaces\Connector;
use GuzzleHttp\Client;

/**
 * Class ConnectionDecorator
 *
 * @package app\ApiConnection
 */
abstract class ConnectionDecorator implements Connector
{
    const GET_REQUEST = 'GET';
    const POST_REQUEST = 'POST';

    /**
     * @var Connector
     */
    protected $connector;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * ConnectionDecorator constructor.
     *
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
        $this->setProperties();
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->connector->getClient();
    }

    /**
     * @return void
     */
    abstract protected function setProperties(): void;

    /**
     * @return array
     */
    public function getAvailableMethods(): array
    {
        return [
            static::GET_REQUEST,
            static::POST_REQUEST
        ];
    }
}