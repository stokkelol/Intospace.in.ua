<?php
declare(strict_types=1);

namespace App\Bot\Spotify;


use App\Models\TelegramUser;

class Spotify
{
    /**
     * @var TelegramUser
     */
    private TelegramUser $user;

    /**
     * Spotify constructor.
     * @param TelegramUser $user
     */
    public function __construct(TelegramUser $user) {

        $this->user = $user;
    }
}