<?php
declare(strict_types=1);

namespace App\Bot\Lastfm;

/**
 * Class FindLinks
 *
 * @package App\Bot\Lastfm
 */
class FindLinks
{
    /**
     * @var Lastfm
     */
    private $api;

    /**
     * SimilarityParser constructor.
     *
     * @param Lastfm $api
     */
    public function __construct(Lastfm $api)
    {
        $this->api = $api;
    }

    /**
     * @return void
     */
    public function handle(): void
    {

    }
}