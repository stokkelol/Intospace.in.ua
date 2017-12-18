<?php
declare(strict_types=1);

namespace App\Bot\Lastfm;

use App\ApiConnection\ConnectionDecorator;

/**
 * Class Handler
 *
 * @package App\Bot\Lastfm
 */
class Lastfm extends ConnectionDecorator
{
    const ENDPOINT = 'http://ws.audioscrobbler.com/2.0/';

    /**
     * @var array
     */
    private $request;

    /**
     * @return void
     */
    protected function setProperties(): void
    {
        $this->endpoint = static::ENDPOINT;

        $this->request = [
            'format' => config('lastfm.format'),
            'api_key' => config('lastfm.api_key')
        ];
    }

    public function getUserInfo()
    {
        $this->request = \array_merge($this->request, [
            'method' => 'user.getInfo',
            'user' => 'redwhite1'
        ]);

        return $this;
    }

    public function get(): array
    {
        $handler = new Handler($this->connector->getClient());

        $response = $handler->get($this->endpoint, $this->request);

        return \json_decode($response->getBody()->getContents(), true);
    }
}