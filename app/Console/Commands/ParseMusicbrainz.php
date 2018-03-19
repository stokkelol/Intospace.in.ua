<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Bot\Musicbrainz\Musicbrainz;
use App\Models\Album;
use App\Models\Band;
use App\Models\Country;
use App\Models\Label;
use App\Models\Track;
use Illuminate\Console\Command;
use Illuminate\Container\Container;

/**
 * Class ParseMusicbrainz
 *
 * @package App\Console\Commands
 */
class ParseMusicbrainz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'musicbrainz:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var Musicbrainz
     */
    private $api;

    /**
     * ParseMusicbrainz constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->api = Container::getInstance()->make(Musicbrainz::class);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $this->updateBands();
        $this->updateAlbums();

//        if (Carbon::now()->endOfMonth()) {
//            $this->updateBands();
//        } else {
//            $this->updateAlbums();
//        }
    }

    /**
     * @return void
     */
    public function updateBands(): void
    {
        Band::query()->whereDoesntHave('albums')->chunk(500, function ($bands) {
            /** @var Band $band */
            foreach ($bands as $band) {
                if ($band->mbid !== null && $band->mbid !== '') {
                    if (!$band->albums()->exists()) {
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
                                    $record = new Album();
                                    $record->band()->associate($band);
                                    $record->title = $album['title'];
                                    $record->mbid = $album['id'];
                                    $record->release_date = $album['date'] ?? null;
                                    $record->save();
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
     * @return void
     */
    public function updateAlbums(): void
    {
        Album::query()->chunk(200, function ($albums) {
            foreach ($albums as $album) {
                $response = $this->api->getAlbumDetails($album->mbid);

                if (isset($response['label-info'][0])) {
                    $label = $response['label-info'][0];
                    $labelModel = Label::query()->where('mbid', '=', $label['label']['id'])->first();

                    if ($labelModel === null) {
                        $labelModel = new Label();
                        $labelModel->mbid = $label['label']['id'];
                        $labelModel->title = $label['label']['name'];
                        $labelModel->country_id = null;
                        $labelModel->code = $label['label']['label-code'] ?? null;
                        $labelModel->disambiguation = $label['label']['disambiguation'];
                        $labelModel->save();
                    }

                    $album->label_id = $labelModel['id'];
                    $album->catalog_number = $label['catalog-number'];
                    $album->save();
                }

                $media = $response['media'][0];
                $band = Band::query()->find($album->band_id);

                if ($album->tracks()->get()->isEmpty()) {
                    foreach ($media['tracks'] as $track) {
                        $trackModel = new Track();
                        $trackModel->mbid = $track['id'];
                        $trackModel->title = $track['title'];
                        $trackModel->album()->associate($album);
                        $trackModel->band()->associate($band);
                        $trackModel->disambiguation = null;
                        $trackModel->position = $track['position'];
                        $trackModel->length = $track['length'];
                        $trackModel->save();
                    }
                }

                sleep(1);
            }

        });
    }
}
