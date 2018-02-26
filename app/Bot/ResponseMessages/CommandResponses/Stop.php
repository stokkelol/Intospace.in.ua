<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;

/**
 * Class Stop
 * 
 * @package App\Bot\ResponseMessages\CommandResponses
 */
class Stop extends BaseCommand implements Command
{
    public function prepare(): array
    {

    }
}