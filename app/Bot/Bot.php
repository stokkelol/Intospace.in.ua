<?php
declare(strict_types=1);

namespace App\Bot;

use App\Models\Chat;
use App\Models\TelegramUser;
use Illuminate\Http\Request;
use Telegram\Bot\Api;

/**
 * Class Bot
 *
 * @package App\Bot
 */
class Bot
{
    /**
     * @var Api
     */
    private $telegram;

    /**
     * @var TelegramUser
     */
    private $user;

    /**
     * @var Chat
     */
    private $chat;

    /**
     * Bot constructor.
     * @param Api $telegram
     * @param TelegramUser $user
     * @param Chat $chat
     */
    public function __construct(
        Api $telegram,
        TelegramUser $user,
        Chat $chat
    ) {
        $this->telegram = $telegram;
        $this->user = $user;
        $this->chat = $chat;
    }

    public function processWebhook($request)
    {
        $this->processRequest($request);

        [$user, $chat] = $this->processInitialRequest($request);

        $this->telegram->sendMessage([
            'chat_id' =>$chat->id,
            'text' => 'Hi!' . $user->user_name
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function processInitialRequest($request): array
    {
        $from = $request['message']['from'];
        $fromChat = $request['message']['chat'];

        $user = $this->user->where('id', $from['id'])->first();
        $chat = $this->chat->where('id', $fromChat['id'])->first();

        if ($user === null) {
            $user = new TelegramUser();
            $user->first_name = $from['first_name'] ?? null;
            $user->last_name = $from['last_name'] ?? null;
            $user->user_name = $from['username'] ?? null;
            $user->language_code = $from['language_code'] ?? null;
            $user->save();
        }

        if ($chat === null) {
            $chat = new Chat();
            $chat->type = $fromChat['type'];
            $chat->title = $fromChat['first_name'] ?? null;
            $chat->name = $fromChat['username'] ?? null;
            $chat->is_all_admins = false;
            $chat->old_chat_id = null;
            $chat->save();
        }

        return [$user, $chat];
    }
}