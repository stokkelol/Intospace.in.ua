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
        do {
            $this->searchBand();
            $searcher = new Youtube();
            $result = $searcher->searchBand($this->band);
        } while (!\is_array($result));

        return [static::YOUTUBE_ENDPOINT . $this->getVideoId($result)];
    }

    /**
     * @return array
     */
    public function searchBand(): void
    {
        $tag = Tag::query()->where('tag', '=', $this->getTag())->with('bands')->first();
        $this->band = $tag->bands->random();
    }

    /**
     * @return string
     */
    private function getTag(): string
    {
        return static::$map[$this->type];
    }

    /**
     * @param array $results
     * @return string
     */
    private function getVideoId(array $results): string
    {
        return $results[0]->id->videoId;
    }
}