<?php
declare(strict_types=1);

namespace app\ApiConnection;

use App\ApiConnection\Interfaces\Connector;

/**
 * Class ConnectionDecorator
 *
 * @package app\ApiConnection
 */
abstract class ConnectionDecorator
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
     * @param array $config
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
        $this->setProperties();
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