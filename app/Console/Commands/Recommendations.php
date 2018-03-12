<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Bot\Recommendations\Payload;
use App\Bot\Youtube\Youtube;
use App\Models\Band;
use App\Models\BandTelegramUser;
use App\Models\TelegramUser;
use App\Models\TelegramUserRecommendation;
use Illuminate\Console\Command;

/**
 * Class Recommendations
 *
 * @package App\Console\Commands
 */
class Recommendations extends Command
{
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
     * Recommendations constructor.
     * @param Youtube $youtube
     * @param Payload $payload
     */
    public function __construct(Youtube $youtube, Payload $payload)
    {
        parent::__construct();

        $this->youtube = $youtube;
        $this->payload = $payload;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        TelegramUser::query()->chunk(1000, function ($users) {
            /** @var TelegramUser $user */
            foreach ($users as $user) {
                if ($user->isLastfmExists()) {
                    $maxBand = BandTelegramUser::query()->where('user_id', $user->id)
                        ->orderBy('lastfm_count', 'desc')->first();
                    $band = Band::query()->find($maxBand->band_id);
                    $video = $this->youtube->search($band->title);

                    $payload = $this->payload->processRecommendation($video);

                    $recommendation = new TelegramUserRecommendation();
                    $recommendation->user()->associate($user);
                    $recommendation->band()->associate($band);
                    $recommendation->payload = $payload;
                    $recommendation->save();
                }
            }
        });
    }
}
