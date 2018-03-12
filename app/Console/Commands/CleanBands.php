<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Band;
use Illuminate\Console\Command;

/**
 * Class CleanBands
 *
 * @package App\Console\Commands
 */
class CleanBands extends Command
{
    /**
     * @var array
     */
    private static $corruptionMap = [
        '///'
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bands:clean';

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
        /** Band[] $bands */
        Band::query()->chunk(2000, function ($bands) {
            foreach ($bands as $band) {
                if (\mb_strpos($band->title, static::$corruptionMap)) {
                    $band->delete();
                }
            }
        });
    }
}
