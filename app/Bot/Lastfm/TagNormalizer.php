<?php
declare(strict_types=1);

namespace App\Bot\Lastfm;

/**
 * Class TagNormalizer
 *
 * @package App\Bot\Lastfm
 */
class TagNormalizer
{
    /**
     * @param string $string
     * @return string
     */
    public static function normalize(string $string): string
    {
        return \str_replace('+', '', $string);
    }
}