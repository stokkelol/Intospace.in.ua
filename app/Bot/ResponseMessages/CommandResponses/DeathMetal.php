<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;

/**
 * Class DeathMetal
 *
 * @package app\Bot\ResponseMessages\CommandResponses
 */
class DeathMetal extends BaseCommand implements Command
{
    /**
     * @return array
     */
    public function prepare(): array
    {
        return [static::POSTS_ENDPOINT . $this->post->getRandomPostByTag('death metal')->slug];
    }
}