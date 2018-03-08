<?php
declare(strict_types=1);

namespace App\Bot\Lastfm;

/**
 * Class Parser
 *
 * @package App\Bot\Lastfm
 */
class Parser
{
    /**
     * @var Lastfm
     */
    private $api;

    /**
     * Parser constructor.
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