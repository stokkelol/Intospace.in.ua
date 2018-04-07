<?php
declare(strict_types=1);

namespace App\Support\Nohup;

/**
 * Class Run
 * 
 * @package App\Support\Nohup
 */
final class ViaNohup
{
    /**
     * @param string $command
     */
    public static function run(string $command): void
    {
        exec('nohup ' . $command . ' 2>> ./storage/logs/nohup.error.log >> ./storage/logs/nohup.log &');
    }
}