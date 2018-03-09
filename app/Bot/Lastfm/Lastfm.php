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
    private static $bindings = [
        'getArtistInfo' => 'artist.getInfo',
        'getUserInfo' => 'user.getInfo',
        'getUserTopArtists' => 'user.getTopArtists',
        'getUserTopAlbums' => 'user.getTopAlbums',
        'getUserTopTags' => 'user.getTopTags'
    ];

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

    /**
     * @param string $name
     * @return Lastfm
     */
    public function getArtistInfo(string $name): self
    {
        return $this->set($this->setQuery(__METHOD__, ['artist' => $name]));
    }

    /**
     * @param string $username
     * @return $this
     */
    public function getUserInfo(string $username): self
    {
        return $this->set($this->setQuery(__METHOD__, ['user' => $username]));
    }

    /**
     * @param string $username
     * @return $this
     */
    public function getUserTopArtists(string $username): self
    {
        return $this->set($this->setQuery(__METHOD__, ['user' => $username, 'limit' => 5]));
    }

    /**
     * @param string $username
     * @return $this
     */
    public function getUserTopAlbums(string $username): self
    {
        return $this->set($this->setQuery(__METHOD__, ['user' => $username]));
    }

    /**
     * @param string $username
     * @return Lastfm
     */
    public function getUserTopTags(string $username): self
    {
        return $this->set($this->setQuery(__METHOD__, ['user' => $username]));
    }

    /**
     * @param string $username
     * @return Lastfm
     */
    public function getUserTopTracks(string $username): self
    {
        return $this->set($this->setQuery(__METHOD__, ['user' => $username]));
    }

    /**
     * @return array
     * @throws \RuntimeException
     */
    public function get(): array
    {
        $handler = new Handler($this->getClient());

        $response = $handler->get($this->endpoint, $this->request);

        if ($response->getStatusCode() === 200) {
            return \json_decode($response->getBody()->getContents(), true);
        }
    }

    /**
     * @param array $args
     * @return $this
     */
    private function set(array $args): self
    {
        $this->request = \array_merge($this->request, $args);

        return $this;
    }

    /**
     * @param string $method
     * @param array $args
     * @return array
     */
    private function setQuery(string $method, array $args): array
    {
        return \array_merge([
            'method' => $this->getBindings($method)
        ], $args);
    }

    /**
     * @param string $method
     * @return string
     */
    private function getBindings(string $method): string
    {
        return static::$bindings[\explode('::', $method)[1]];
    }
}