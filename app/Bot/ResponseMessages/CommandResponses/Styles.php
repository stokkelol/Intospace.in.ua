<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;
use App\Bot\Youtube\Youtube;
use App\Models\Band;
use App\Models\BandTag;
use App\Models\BotCommand;
use App\Models\Tag;

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
        $tag = Tag::query()->where('tag', '=', $this->getTag())
            ->with('bands')->first();

        $this->band = $tag->bands->random();

        $gatherer = new StatisticGatherer($this->user);
        $gatherer->associateBandAndUser($this->band);
        $gatherer->associateTagAndUser($this->band);

        $searcher = new Youtube();
        $result = $searcher->search($this->band->title);

        $this->album = $searcher->getAlbum();
        $this->track = $searcher->getTrack();

        return [static::YOUTUBE_ENDPOINT . $result[0]->id->videoId];
    }

    /**
     * @return string
     */
    private function getTag(): string
    {
        return static::$map[$this->type];
    }
}