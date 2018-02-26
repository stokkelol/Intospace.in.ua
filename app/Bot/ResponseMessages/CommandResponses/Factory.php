<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;
use App\Models\TelegramUser;

/**
 * Class Factory
 *
 * @package App\Bot\ResponseMessages\CommandResponses
 */
final class Factory
{
    private static $commandsMap = [];

    /**
     * @param string $type
     * @param TelegramUser $user
     * @return Command
     */
    public static function build(string $type, TelegramUser $user): Command
    {
        switch ($type) {
            case '/latest':
                return new Latest($type, $user);
                break;
            case '/blackmetal':
            case '/deathmetal':
            case '/sludge':
            case '/technicaldeathmetal':
            case '/sludgedoom':
            case '/experimental':
            case '/psychedelic':
            case '/doommetal':
                return new Styles($type, $user);
                break;
            case '/youtube':
                return new YoutubeSearch($type, $user);
                break;
            case '/stop':
                return new Stop($type, $user);
                break;
            case '/start':
                return new Start($type, $user);
                break;
            case '/help':
                return new Help($type, $user);
                break;
        }
    }
}