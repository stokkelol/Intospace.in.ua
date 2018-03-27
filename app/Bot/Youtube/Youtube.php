<?php
declare(strict_types=1);

namespace App\Bot\Youtube;
use App\Models\Band;

/**
 * Class Youtube
 *
 * @package App\Bot\Youtube
 */
class Youtube
{
    /**
     * @var \Alaouy\Youtube\Youtube
     */
    private $handler;

    /**
     * @var \App\Models\Album|null
     */
    private $album;

    /**
     * @var \App\Models\Track|null
     */
    private $track;

    /**
     * Youtube constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->handler = new \Alaouy\Youtube\Youtube(config('youtube.key'));
    }

    /**
     * @param string $query
     *
     */
    public function search(string $query)
    {
        return $this->handler->searchVideos($query);
    }

    /**
     * @param Band $band
     * @return string
     * @throws \InvalidArgumentException
     */
    public function searchBand(Band $band)
    {
        $band->load('albums', 'albums.tracks');

        if ($band->albums->isNotEmpty()) {
            $this->album = $band->albums->random();

            if ($this->album->tracks->isNotEmpty()) {
                $this->track = $this->album->tracks->random();

                $searchString = $band->title . ' ' . $this->track->title;
            } else {
                $searchString = $band->title . ' ' . $this->album->title;
            }
        } else {
            $searchString = $band->title;
        }

        return $this->search($searchString);
    }

    /**
     * @return \App\Models\Track|null
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * @return \App\Models\Album|null
     */
    public function getAlbum()
    {
        return $this->album;
    }
}