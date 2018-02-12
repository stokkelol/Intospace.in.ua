<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class SendAfternoonMessage
 *
 * @package App\Console\Commands
 */
class SendAfternoonMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:afternoon';

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
        //
    }
}
