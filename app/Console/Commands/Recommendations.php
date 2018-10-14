<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Bot\Recommendations\Payload;
use App\Bot\Recommendations\Processor;
use App\Bot\Youtube\Youtube;
use App\Models\Band;
use App\Models\BandTelegramUser;
use App\Models\TelegramUser;
use App\Models\TelegramUserRecommendation;
use App\Traits\RandomOrder;
use Illuminate\Console\Command;

/**
 * Class Recommendations
 *
 * @package App\Console\Commands
 */
class Recommendations extends Command
{
    use RandomOrder;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:recommendation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var Youtube
     */
    private $youtube;

    /**
     * @var Payload
     */
    private $payload;

    /**
     * @var Processor
     */
    private $processor;

    /**
     * Recommendations constructor.
     * @param Youtube $youtube
     * @param Payload $payload
     * @param Processor $processor
     */
    public function __construct(Youtube $youtube, Payload $payload, Processor $processor)
    {
        parent::__construct();

        $this->youtube = $youtube;
        $this->payload = $payload;
        $this->processor = $processor;
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function handle(): void
    {
        TelegramUserRecommendation::query()->where('is_dispatched', false)->update([
            'is_dispatched' => TelegramUserRecommendation::TYPE_ARCHIVED
        ]);

        TelegramUser::query()->chunk(1000, function ($users) {
            /** @var TelegramUser $user */
            foreach ($users as $user) {
                $band = $user->isLastfmExists() ? $this->getRecommendedBand($user) : $this->getRandomBand();

                $video = $this->youtube->searchBand($band);
                if (\is_array($video)) {
                    $payload = $this->payload->processRecommendation($video);
                    $this->saveRecommendation($band, $user, $payload);
                }
            }
        });
    }

    /**
     * @param TelegramUser $user
     * @return Band
     * @throws \InvalidArgumentException
     */
    private function getRecommendedBand(TelegramUser $user): Band
    {
        return $this->processor->handle($user);
    }

    /**
     * @return Band
     */
    private function getRandomBand(): Band
    {
        /** @var Band $band */
        $band = Band::query()->with('albums', 'albums.tracks')->find(\random_int(1, Band::query()->count()));

        return $band;
    }

    /**
     * @param Band $band
     * @param TelegramUser $user
     * @param $payload
     * @return void
     */
    private function saveRecommendation(Band $band, TelegramUser $user, $payload): void
    {
        $recommendation = new TelegramUserRecommendation();
        $recommendation->user()->associate($user);
        $recommendation->band()->associate($band);
        $recommendation->payload = $payload;
        $recommendation->save();
    }
}
