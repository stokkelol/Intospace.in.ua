<?php
declare(strict_types=1);

namespace App\Bot\Lastfm;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Handler
 *
 * @package App\Bot\Lastfm
 */
class Handler
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Handler constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $endpoint
     * @param array $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get(string $endpoint, array $request): ResponseInterface
    {
        return $this->client->get($endpoint, [
            'query' => $request
        ]);
    }
}