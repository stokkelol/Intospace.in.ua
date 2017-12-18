<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;

/**
 * Class Sludge
 *
 * @package App\Bot\ResponseMessages\CommandResponses
 */
class Sludge extends BaseCommand implements Command
{
    public function prepare(): array
    {
        return [static::POSTS_ENDPOINT . $this->post->getRandomPostByTag('sludge')->slug];
    }
}