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
    const ENDPOINT = 'https://www.intospace.in.ua/posts/';

    /**
     * @return array
     */
    public function prepare(): array
    {
        $post = $this->post->getBlackMetal();

        return [static::ENDPOINT . $post->slug];
    }
}