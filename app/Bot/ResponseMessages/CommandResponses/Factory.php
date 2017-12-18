<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;

/**
 * Class Factory
 *
 * @package app\Bot\ResponseMessages\CommandResponses
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
                return new Latest();
            case '/blackmetal':
                return new BlackMetal();
            case '/deathmetal':
                return new DeathMetal();
            case '/sludge':
                return new Sludge();
            case '/technicaldeathmetal':
                return new TechnicalDeathMetal();
            case '/sludgedoom':
                return new SludgeDoom();
            case '/experimental':
                return new Experimental();
            case '/psychedelic':
                return new Psychedelic();
            case '/doommetal':
                return new DoomMetal();
        }
    }
}