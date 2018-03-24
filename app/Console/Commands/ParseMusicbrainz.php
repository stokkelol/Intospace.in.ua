<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Bot\Musicbrainz\Musicbrainz;
use App\Bot\Musicbrainz\Parser;
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
     *
     * @param Musicbrainz $api
     */
    public function __construct(Musicbrainz $api)
    {
        parent::__construct();

        $this->api = $api;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $parser = new Parser($this->api);

        $parser->updateBands();
        $parser->updateAlbums();
    }
}
