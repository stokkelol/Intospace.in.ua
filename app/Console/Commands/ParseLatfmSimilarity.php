<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Bot\Lastfm\Lastfm;
use App\Bot\Lastfm\SimilarityParser;
use Illuminate\Console\Command;
use Illuminate\Container\Container;

/**
 * Class ParseLatfmSimilarity
 *
 * @package App\Console\Commands
 */
class ParseLatfmSimilarity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lastfm:similarity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        (new SimilarityParser(Container::getInstance()->make(Lastfm::class)))->handle();
    }
}
