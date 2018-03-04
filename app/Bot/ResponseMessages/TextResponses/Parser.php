<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\TextResponses;

use App\Bot\ResponseMessages\Interfaces\Text;
use App\Bot\ResponseMessages\TextResponse;

/**
 * Class Parser
 * 
 * @package app\Bot\ResponseMessages\TextResponses
 */
class Parser
{
    const SEPARATOR  = '#';

    const BASE_PATTERN = '';

    /**
     * @var array
     */
    private $parts = [];

    /**
     * @var Text
     */
    private $response;

    /**
     * Parser constructor.
     * 
     * @param TextResponse $response
     */
    public function __construct(TextResponse $response)
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    public function parse(): array
    {
        if (!\mb_strpos($this->response->getText(), self::SEPARATOR)) {
            return (new Unknown())->prepare();
        }

        $parts = \explode(self::SEPARATOR, $this->response->getText());

        $this->parts = $parts;

        if (isset($this->parts[0], $this->parts[1])) {
            return $this->parseParts();
        }

        return (new Unknown())->prepare();
    }

    /**
     * @return array
     */
    private function parseParts(): array
    {
        if (\strtolower($this->parts[0]) === 'lastfm') {
            return (new LastFmSetter($this->parts[1], $this->response))->prepare();
        }

        if (\strtolower($this->parts[0]) === 'facebook') {
            return (new LastFmSetter($this->parts[1], $this->response))->prepare();
        }
    }
}