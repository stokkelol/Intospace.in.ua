<?php
declare(strict_types=1);

namespace App\Bot\Lastfm;

use App\Models\Band;
use App\Models\Social;
use App\Models\TelegramUser;

/**
 * Class Parser
 *
 * @package App\Bot\Lastfm
 */
class Parser
{
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
     */
    private function updateUsersBands(): void
    {
        TelegramUser::query()->with('socials', 'bands')->chunk(500, function ($users) {
            /** TelegramUser $user */
            foreach ($users as $user) {
                $userLastfm = $user->socials->where('id', '=', Social::LASTFM)->first();
                if (!empty($userLastfm)) {
                    $artists = $this->api->getUserTopArtists($userLastfm->pivot->value)->get();

                    $this->handleUserAndBands($user, $artists['topartists']['artist']);
                }
            }
        });
    }

    /**
     * @param TelegramUser $user
     * @param array $artists
     * @return void
     */
    private function handleUserAndBands(TelegramUser $user, array $artists): void
    {

        foreach ($artists as $band) {

            $bandModel = Band::query()->where('title', '=', $band['name'])->first();

            $bandModel = $bandModel === null ? $this->saveBand($band) : $this->updateBand($band, $bandModel);
        }
    }

    /**
     * @param array $bandArray
     * @return Band
     */
    private function saveBand(array $bandArray): Band
    {
        $band = new Band();

        $band->title = $bandArray['name'];
        $band->lastfm_url = $bandArray['url'];
        $band->save();

        return $band;
    }

    /**
     * @param array $bandArray
     * @param Band $model
     * @return Band
     */
    private function updateBand(array $bandArray, Band $model): Band
    {
        $model->title = $bandArray['name'];
        $model->lastfm_url = $bandArray['url'];
        $model->save();

        return $model;
    }
}