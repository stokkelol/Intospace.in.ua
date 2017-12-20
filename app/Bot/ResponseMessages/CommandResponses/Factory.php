<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;

/**
 * Class Factory
 *
 * @package App\Bot\ResponseMessages\CommandResponses
 */
final class Factory
{
    /**
     * @param string $type
     * @return Command
     */
    public static function build(string $type): Command
    {
        switch ($type) {
            case '/latest':
                return new Latest($type);
            case '/blackmetal':
            case '/deathmetal':
            case '/sludge':
            case '/technicaldeathmetal':
            case '/sludgedoom':
            case '/experimental':
            case '/psychedelic':
            case '/doommetal':
                return new Styles($type);
        }
    }
}