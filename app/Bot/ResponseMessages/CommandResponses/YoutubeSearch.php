<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;

/**
 * Class YoutubeSearch
 *
 * @package App\Bot\ResponseMessages\CommandResponses
 */
class YoutubeSearch extends BaseCommand implements Command
{
    /**
     * @return array
     */
    public function prepare(): array
    {
        
    }
}