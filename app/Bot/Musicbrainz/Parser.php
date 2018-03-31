<?php
declare(strict_types=1);

namespace App\Bot\Musicbrainz;
use App\Models\Album;
use App\Models\Band;
use App\Models\Country;
use App\Models\Label;
use App\Models\Track;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Parser
 * @package app\Bot\Musicbrainz
 */
class Parser
{
    /**
     * @var Musicbrainz
     */
    private $api;

    /**
     * Parser constructor.
     * @param Musicbrainz $api
     */
    public function __construct(Musicbrainz $api)
    {
        $this->api = $api;
    }

    /**
     * @return void
     */
    public function updateBands(): void
    {
        now()->isSunday()
            ? $this->updateAllBands()
            : $this->saveNewBands();
    }


    /**
     * @return void
     */
    public function updateAlbums(): void
    {
        now()->isMonday()
            ? $this->updateAllAlbums()
            : $this->saveNewAlbums();
    }

    /**
     * @return void
     */
    private function updateAllAlbums(): void
    {
        $this->saveAlbums(Album::query());
    }

    /**
     * @return void
     */
    private function saveNewAlbums(): void
    {
        $this->saveAlbums(Album::query()->whereDoesntHave('tracks'));
    }

    /**
     * @return void
     */
    private function updateAllBands(): void
    {
        $this->saveBands(Band::query());
    }

    /**
     * @return void
     */
    private function saveNewBands(): void
    {
        $this->saveBands(Band::query()->whereDoesntHave('albums'));
    }

    /**
     * @return void
     */
    private function saveAlbums(Builder $query): void
    {
        $query->chunk(200, function ($albums) {
            foreach ($albums as $album) {
                $response = $this->api->getAlbumDetails($album->mbid);

                if (isset($response['label-info'][0])) {
                    $label = $response['label-info'][0];
                    $labelModel = Label::query()->where('mbid', '=', $label['label']['id'])->first();

                    if ($labelModel === null) {
                        $labelModel = $this->saveLabel($label);
                    }

                    $album->label_id = $labelModel['id'];
                    $album->catalog_number = $label['catalog-number'];
                    $album->save();
                }

                if (isset($response['media'][0])) {
                    $media = $response['media'][0];
                    /** @var Band $band */
                    $band = Band::query()->find($album->band_id);
                    if ($album->tracks()->get()->isEmpty() && isset($media['tracks'])) {
                        foreach ($media['tracks'] as $track) {
                            $track = $this->saveTrack($track, $album, $band);
                        }
                    }

                }
                sleep(1);
            }

        });
    }

    /**
     * @param Builder $query
     * @return void
     */
    private function saveBands(Builder $query): void
    {
        $query->chunk(500, function ($bands) {
            /** @var Band $band */
            foreach ($bands as $band) {
                if ($band->mbid !== null && $band->mbid !== '') {
                    if (!$band->albums()->exists()) {
                        \var_dump($band->title);
                        $response = $this->api->getAlbums($band->mbid);

                        if ($response !== null) {
                            if ($band->country_id === null) {
                                $country = Country::query()->where('abbreviation', '=', $response['country'])->first();
                                if ($country !== null) {
                                    $band->country_id = $country->id;
                                }
                            }

                            if ($band->disambiguation === null) {
                                $band->disambiguation = $response['disambiguation'];
                            }

                            if ($band->isDirty()) {
                                $band->save();
                            }

                            foreach ($response['releases'] as $album) {
                                if (!Album::query()->where('mbid', '=', $album['id'])->exists()) {
                                    $album = $this->saveAlbum($album, $band);
                                }
                            }

                            sleep(1);
                        }
                    }
                }
            }
        });
    }

    /**
     * @param array $track
     * @param Album $album
     * @param Band $band
     * @return Track
     */
    private function saveTrack(array $track, Album $album, Band $band): Track
    {
        $trackModel = new Track();
        $trackModel->mbid = $track['id'];
        $trackModel->title = $track['title'];
        $trackModel->album()->associate($album);
        $trackModel->band()->associate($band);
        $trackModel->disambiguation = null;
        $trackModel->position = $track['position'];
        $trackModel->length = $track['length'];
        $trackModel->save();

        return $trackModel;
    }

    /**
     * @param array $label
     * @return Label
     */
    private function saveLabel(array $label): Label
    {
        $labelModel = new Label();
        $labelModel->mbid = $label['label']['id'];
        $labelModel->title = $label['label']['name'] ?? '';
        $labelModel->country_id = null;
        $labelModel->code = $label['label']['label-code'] ?? null;
        $labelModel->disambiguation = $label['label']['disambiguation'];
        $labelModel->save();

        return $labelModel;
    }

    /**
     * @param array $album
     * @param Band $band
     * @return Album
     */
    private function saveAlbum(array $album, Band $band): Album
    {
        $record = new Album();
        $record->band()->associate($band);
        $record->title = $album['title'];
        $record->mbid = $album['id'];
        $record->release_date = $album['date'] ?? null;
        $record->save();

        return $record;
    }
}