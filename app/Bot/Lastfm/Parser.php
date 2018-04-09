<?php
declare(strict_types=1);

namespace App\Bot\Lastfm;

use App\Models\Band;
use App\Models\BandTelegramUser;
use App\Models\Social;
use App\Models\TelegramUser;
use App\Support\Logger\Logger;
use Carbon\Carbon;

/**
 * Class Parser
 *
 * @package App\Bot\Lastfm
 */
class Parser
{
    const FIRST_PAGE = 1;

    /**
     * @var Lastfm
     */
    private $api;

    /**
     * Parser constructor.
     * 
     * @param Lastfm $api
     */
    public function __construct(Lastfm $api)
    {
        $this->api = $api;
    }

    /**
     * @return void
     * @throws \RuntimeException
     */
    public function handle(): void
    {
        $this->updateUsersBands();
        $this->updateBands();
    }

    /**
     * @return void
     * @throws \RuntimeException
     */
    private function updateBands(): void
    {
        $bands = Band::query()->whereNull('lastfm_url')->get();

        foreach ($bands as $band) {
            \mb_strpos($band->title, '(') ? $bandTitle = $this->prepareTitle($band->title) : $bandTitle = $band->title;

            $artist = $this->api->getArtistInfo($bandTitle)->get();
            $band->mbid = $artist['artist']['mbid'];
            $band->lastfm_url = $artist['artist']['url'];
            $band->save();
        }
    }

    /**
     * @param string $title
     * @return string
     */
    private function prepareTitle(string $title): string
    {
        return \trim(\explode('(', $title)[0]);
    }

    /**
     * @return void
     * @throws \RuntimeException
     */
    private function updateUsersBands(): void
    {
        Logger::log(__METHOD__ . ' started at ' . Carbon::now());

        TelegramUser::query()->with('socials', 'bands')->chunk(500, function ($users) {
            /** TelegramUser $user */
            foreach ($users as $user) {
                $page = static::FIRST_PAGE;
                $userLastfm = $user->socials->where('id', '=', Social::LASTFM)->first();

                try {
                    if ($userLastfm !== null) {
                        do {
                            $artists = $this->api->getUserTopArtists($userLastfm->pivot->value, $page)->get();

                            $this->handleUserAndBands($user, $artists['topartists']['artist']);
                            $page++;
                        } while (count($artists['topartists']['artist']) !== 0);
                    }
                } catch (\Throwable $e) {
                    Logger::exception($e);
                }
            }
        });

        Logger::log(__METHOD__ . ' ended at ' . Carbon::now());
    }

    /**
     * @param TelegramUser $user
     * @param array $artists
     * @return void
     * @throws \RuntimeException
     */
    private function handleUserAndBands(TelegramUser $user, array $artists): void
    {
        foreach ($artists as $band) {
            if (\strlen($band['name']) < 128) {
                $bandModel = Band::query()->where('title', '=', $band['name'])->first();
                $bandModel = $bandModel === null ? $this->saveBand($band) : $this->updateBand($band, $bandModel);

                $bandTelegramUser = BandTelegramUser::query()->where('user_id', '=',$user->id)
                    ->where('band_id', '=', $bandModel->id)->first();

//            $existedTags = $user->tags;
//            $tags = $this->api->getArtistTopTags($band['name'])->get();

                try {
                    if ($bandTelegramUser === null) {
                        $bandTelegramUser = new BandTelegramUser();
                        $bandTelegramUser->user_id = $user->id;
                        $bandTelegramUser->band_id = $bandModel->id;
                        $bandTelegramUser->lastfm_count = $band['playcount'];
                        $bandTelegramUser->save();
                    }

                    if ($this->isUpdate() || $bandTelegramUser->lastfm_count === null) {
                        $bandTelegramUser->lastfm_count = $band['playcount'];
                        $bandTelegramUser->save();
                    }
                } catch (\Throwable $e) {
                    Logger::exception($e);
                }
            }
        }
    }

    /**
     * @return bool
     */
    private function isUpdate(): bool
    {
        return Carbon::now()->isSaturday();
    }

    /**
     * @param array $bandArray
     * @return Band
     */
    private function saveBand(array $bandArray): Band
    {
        return $this->performBandSave(new Band(), $bandArray);
    }

    /**
     * @param array $bandArray
     * @param Band $model
     * @return Band
     */
    private function updateBand(array $bandArray, Band $model): Band
    {
        return $this->performBandSave($model, $bandArray);
    }

    /**
     * @param Band $band
     * @param array $bandArray
     * @return Band
     */
    private function performBandSave(Band $band, array $bandArray): Band
    {
        $band->title = $bandArray['name'];
        $band->lastfm_url = $bandArray['url'];
        $band->mbid = $bandArray['mbid'];
        $band->save();

        return $band;
    }
}