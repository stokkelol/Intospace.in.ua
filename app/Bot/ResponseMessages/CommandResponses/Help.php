<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;

/**
 * Class Help
 *
 * @package App\Bot\ResponseMessages\CommandResponses
 */
class Help extends BaseCommand implements Command
{
    const MESSAGE = '**I can do many things. Just hit with one of the following commands:**
     /help - 
     /start - 
     /stop - 
     /latest -
     /youtube -
     /search - 
     /blackmetal
     /deathmetal
     /sludge
     /technicaldeathmetal
     /sludgedoom
     /experimental
     /psychedelic';

    /**
     * @return array
     */
    public function prepare(): array
    {
        $result[] = static::MESSAGE;

        return $result;
    }
}