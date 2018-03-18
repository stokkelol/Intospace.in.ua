<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Bot\Musicbrainz\Musicbrainz;
use App\Models\Album;
use App\Models\Band;
use App\Models\Country;
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
        Band::query()->chunk(500, function ($bands) {
            /** @var Band $band */
            foreach ($bands as $band) {
                if ($band->mbid !== null && $band->mbid !== '') {
                    $response = $this->api->getAlbums($band->mbid);

                    if ($band->country_id === null) {
                        $country = Country::query()->where('abbreviation', '=', $response['country'])->first();
                        if ($country !== null) {
                            $band->country_id = $country->id;
                        }
                    }

                    if ($band->description === null) {
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
        });
    }
}
