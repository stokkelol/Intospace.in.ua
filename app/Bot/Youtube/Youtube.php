<?php
declare(strict_types=1);

namespace App\Bot\Youtube;

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
}