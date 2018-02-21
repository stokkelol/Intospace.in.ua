<?php
declare(strict_types=1);

namespace App\Bot\Broadcast;

/**
 * Class BaseBroadcast
 *
 * @package app\Bot\Broadcast
 */
abstract class BaseBroadcast
{
    /**
     * @var
     */
    protected $chats;

    /**
     * Morning constructor.
     *
     * @param $chats
     */
    public function __construct($chats)
    {
        $this->chats = $chats;
    }
}