<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;

/**
 * Class Relevant
 *
 * @package App\Bot\ResponseMessages\CommandResponses
 */
class Relevant extends BaseCommand implements Command
{
    /**
     * @return array
     */
    public function prepare(): array
    {

    }
}