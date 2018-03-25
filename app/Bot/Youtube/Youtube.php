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
     * @return \stdClass
     */
    public function search(string $query)
    {
        return $this->handler->searchVideos($query);
    }

    /**
     * @param Band $band
     * @return string
     */
    public function searchBand(Band $band)
    {
        if ($band->albums->isNotEmpty()) {
            $album = $band->albums->random();

            if ($album !== null) {
                if ($album->tracks->isNotEmpty()) {
                    $track = $album->tracks->random();

                    $searchString = $band->title . ' ' . $track->title;
                } else {
                    $searchString = $band->title . ' ' . $album->title;
                }
            } else {
                $searchString = $band->title;
            }
        } else {
            $searchString = $band->title;
        }

        return $this->search($searchString);
    }
}