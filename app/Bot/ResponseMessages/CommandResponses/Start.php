<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

/**
 * Class Start
 * 
 * @package App\Bot\ResponseMessages\CommandResponses
 */
class Start extends BaseCommand
{
    /**
     * @return array
     */
    public function prepare(): array
    {
        return ['Hi there!'];
    }
}