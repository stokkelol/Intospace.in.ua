<?php
declare(strict_types=1);

namespace App\Bot\Message;

use App\Models\Chat;

/**
 * Class Assembler
 *
 * @package App\Bot\Message
 */
class Assembler
{
    /**
     * @var string
     */
    private $parseMode = 'Markdown';

    /**
     * @var \App\Models\Chat
     */
    private $chat;

    /**
     * @var array
     */
    private $message;

    /**
     * @var bool
     */
    private $resizeKeyboard = true;

    /**
     * @var array
     */
    private $keyboard;

    /**
     * @var bool
     */
    private $oneTimeKeyboard = true;

    /**
     * Assembler constructor.
     *
     * @param Chat $chat
     * @param string $message
     * @param array $keyboard
     */
    public function __construct(Chat $chat, string $message, array $keyboard)
    {
        $this->chat = $chat;
        $this->message = $message;
        $this->keyboard = $keyboard;
    }

    /**
     * @return array
     */
    public function assemble(): array
    {
        return [
            'chat_id' => $this->chat->id,
            'text' => $this->message,
            'parse_mode' => $this->parseMode,
            'reply_markup' => \json_encode([
                    'inline_keyboard' => [$this->keyboard],
                    'resize_keyboard' => $this->resizeKeyboard,
                    'one_time_keyboard' => $this->oneTimeKeyboard
                ]
            )
        ];
    }
}