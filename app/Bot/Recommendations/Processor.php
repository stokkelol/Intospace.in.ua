<?php
declare(strict_types=1);

namespace App\Bot\Recommendations;

use App\Models\Band;
use App\Models\TelegramUser;

/**
 * Class Processor
 *
 * @package App\Bot\Recommendations
 */
class Processor
{
    /**
     * @param TelegramUser $user
     * @return Band
     * @throws \InvalidArgumentException
     */
    public function handle(TelegramUser $user): Band
    {
        $top = $user->getTopBands(100);

        return $top->random();
    }

    /**
     * @param TelegramUser $user
     * @return Band
     */
    public function prepare(TelegramUser $user): Band
    {

    }
}