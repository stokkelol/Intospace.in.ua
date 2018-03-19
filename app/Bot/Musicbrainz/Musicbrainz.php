<?php
declare(strict_types=1);

namespace App\Bot\Musicbrainz;

use App\ApiConnection\Connection;
use App\Support\Logger\Logger;

/**
 * Class Musicbrainz
 *
 * @package App\Bot\Musicbrainz
 */
class Musicbrainz
{
    const ARTIST_URL = 'http://musicbrainz.org/ws/2/artist/';
    const RELEASE_URL = 'http://musicbrainz.org/ws/2/release/';

    /**
     * @var Connection
     */
    private $connection;

    /**
     * Musicbrainz constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return null|array
     */
    public function getAlbums(string $mbid): ?array
    {
        try {
            $response = $this->connection->getClient()->get($this->makeArtistUri($mbid), []);

            if ($response->getStatusCode() === 200) {
                return \json_decode($response->getBody()->getContents(), true);
            }
        } catch (\Throwable $e) {
            Logger::exception($e);
        }

        return null;
    }

    /**
     * @return null|array
     */
    public function getAlbumDetails(string $mbid): ?array
    {
        try {
            $response = $this->connection->getClient()->get($this->makeReleaseUri($mbid), []);

            if ($response->getStatusCode() === 200) {
                return \json_decode($response->getBody()->getContents(), true);
            }
        } catch (\Throwable $e) {
            Logger::exception($e);
        }

        return null;
    }

    /**
     * @param string $mbid
     * @return string
     */
    private function makeArtistUri(string $mbid): string
    {
        return static::ARTIST_URL  . $mbid . '?inc=aliases+releases&fmt=json';
    }

    private function makeReleaseUri(string $mbid): string
    {
        return static::RELEASE_URL  . $mbid . '?inc=artist-credits+labels+discids+recordings&fmt=json';
    }
}