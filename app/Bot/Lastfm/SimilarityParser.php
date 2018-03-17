<?php
declare(strict_types=1);

namespace App\Bot\Lastfm;

use App\Models\Band;
use App\Models\BandSimilarity;

/**
 * Class SimilarityParses
 *
 * @package App\Bot\Lastfm
 */
class SimilarityParser
{
    /**
     * @var Lastfm
     */
    private $api;

    /**
     * SimilarityParser constructor.
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
        $this->updateSimilarity();
    }

    /**
     * @return void
     * @throws \RuntimeException
     */
    private function updateSimilarity(): void
    {
        Band::query()->chunk(1000, function ($bands) {
            foreach ($bands as $band) {
                $response = $this->api->getArtistSimilar($band->title)->get();
                if (isset($response['similarartists'])) {
                    foreach ($response['similarartists']['artist'] as $similarBand) {
                        $similar = Band::query()->where('mbid', $similarBand['mbid'])
                            ->orWhere('title', $similarBand['name'])->first();

                        if ($similar !== null) {
                            $this->saveSimilarity($band, $similar, $similarBand);
                        }
                    }
                }
            }
        });
    }

    /**
     * @param Band $band
     * @param Band $similar
     * @param array $data
     */
    private function saveSimilarity(Band $band, Band $similar, array $data): void
    {
        $similarity = BandSimilarity::query()->where('band_id', $band->id)
            ->where('related_id', $similar->id)->first();

        if ($similarity === null) {
            $similarity = new BandSimilarity();
            $similarity->band_id = $band->id;
            $similarity->related_id = $similar->id;
            $similarity->ratio = $data['match'];
            $similarity->save();
        }
    }
}