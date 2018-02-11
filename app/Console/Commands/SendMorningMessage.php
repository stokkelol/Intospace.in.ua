<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class SendMorningMessage
 *
 * @package App\Console\Commands
 */
class SendMorningMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:morning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send morning message';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

    }
}
