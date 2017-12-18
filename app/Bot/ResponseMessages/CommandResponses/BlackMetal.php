<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\ResponseMessages\Interfaces\Command;

/**
 * Class BlackMetal
 *
 * @package app\Bot\ResponseMessages\CommandResponses
 */
class BlackMetal extends BaseCommand implements Command
{
    /**
     * @return array
     */
    public function prepare(): array
    {
        $post = $this->post->getBlackMetal();

        return [static::POSTS_ENDPOINT . $post->slug];
    }
}