<?php

namespace App\Console\Commands;

use App\Bot\Lastfm\Lastfm;
use App\Bot\Lastfm\Parser;
use Illuminate\Console\Command;
use Illuminate\Container\Container;

class ParseLastfm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lastfm:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse LastFm bands base';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        (new Parser(Container::getInstance()->make(Lastfm::class)))->handle();
    }
}
