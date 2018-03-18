<?php
declare(strict_types=1);

namespace App\Bot\Musicbrainz;

use App\ApiConnection\Connection;

/**
 * Class Musicbrainz
 *
 * @package App\Bot\Musicbrainz
 */
class Musicbrainz
{
    const URL = 'http://musicbrainz.org/ws/2/artist/';

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
        $response = $this->connection->getClient()->get($this->makeUri($mbid), []);

        if ($response->getStatusCode() === 200) {
            return \json_decode($response->getBody()->getContents(), true);
        }

        return null;
    }

    /**
     * @param string $mbid
     * @return string
     */
    private function makeUri(string $mbid): string
    {
        return static::URL  . $mbid . '?inc=aliases+releases&fmt=json';
    }
}