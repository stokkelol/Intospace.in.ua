<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Bot\Lastfm\Lastfm;
use App\Bot\Lastfm\TagsParser;
use App\Models\Band;
use Illuminate\Console\Command;
use Illuminate\Container\Container;

/**
 * Class ParseLastfmBandTags
 *
 * @package App\Console\Commands
 */
class ParseLastfmBandTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lastfm:tags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse lastfm bands tags';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        (new TagsParser(Container::getInstance()->make(Lastfm::class)))->handle();
    }
}
