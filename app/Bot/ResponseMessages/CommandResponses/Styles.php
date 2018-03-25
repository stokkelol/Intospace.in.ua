<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;
use App\Bot\Youtube\Youtube;
use App\Models\Band;
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
     * @throws \Exception
     */
    public function prepare(): array
    {
        $this->band = Band::query()->whereHas('tags', function ($query) {
            $query->where('tag', '=', $this->getTag());
        })->first();

        $gatherer = StatisticGatherer::createFromStyles($this->user, $this->band);
        $gatherer->associateBandAndUser()->associateTagAndUser();

        $searcher = new Youtube();
        $result = $searcher->search($this->band->title);


        return [$result];
    }

    /**
     * @return string
     */
    private function getTag(): string
    {
        return static::$map[$this->type];
    }
}