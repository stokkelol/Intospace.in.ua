<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Config;
use TNTSearch;

class IndexPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'index:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $indexer = TNTSearch::createIndex('posts.index');
        $indexer->query('SELECT id, title, excerpt, content, similar FROM posts');
        $indexer->run();
    }
}
