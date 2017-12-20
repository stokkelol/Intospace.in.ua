<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;
use App\Models\BotCommand;

/**
 * Class Styles
 *
 * @package App\Bot\ResponseMessages\CommandResponses
 */
class Styles extends BaseCommand implements Command
{
    /**
     * @var array
     */
    private static $map = [
        BotCommand::BLACK_METAL => 'black metal',
        BotCommand::DEATH_METAL => 'death metal',
        BotCommand::SLUDGE => 'sludge',
        BotCommand::TECHNICAL_DEATH_METAL => 'technical death metal',
        BotCommand::SLUDGE_DOOM => 'sludge doom',
        BotCommand::EXPERIMENTAL => 'experimental',
        BotCommand::PSYCHEDELIC => 'psychedelic',
        BotCommand::DOOM_METAL => 'doom metal'
    ];

    /**
     * @return array
     */
    public function prepare(): array
    {
        return [static::POSTS_ENDPOINT . $this->post->getRandomPostByTag($this->getTag())->slug];
    }

    /**
     * @return string
     */
    private function getTag(): string
    {
        return static::$map[$this->type];
    }
}