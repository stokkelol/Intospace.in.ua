<?php
declare(strict_types=1);

namespace App\Bot;

use App\MessageType;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\InboundMessage;
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

    public function processWebhook(array $request)
    {
        [$user, $chat] = $this->processInitialRequest($request);


        $name =  $user->user_name ?? $user->first_name;

        $this->telegram->sendMessage([
            'chat_id' => $chat->id,
            'text' => 'Hi ' . $name . '!'
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
            $user = $this->saveUser($from);
        }

        if ($chat === null) {
            $chat = $this->saveChat($fromChat, $user);
        }

        $user->chats()->sync($chat);
        
        $this->saveMessage($request, $user, $chat);

        return [$user, $chat];
    }

    /**
     * @param array $from
     * @return TelegramUser
     */
    private function saveUser(array $from): TelegramUser
    {
        $user = new TelegramUser();
        $user->id = $from['id'];
        $user->first_name = $from['first_name'] ?? null;
        $user->last_name = $from['last_name'] ?? null;
        $user->user_name = $from['username'] ?? null;
        $user->language_code = $from['language_code'] ?? null;
        $user->save();

        return $user;
    }

    /**
     * @param array $fromChat
     * @param TelegramUser $user
     * @return Chat
     */
    private function saveChat(array $fromChat, TelegramUser $user): Chat
    {
        $chat = new Chat();
        $chat->id = $fromChat['id'];
        $chat->type = $fromChat['type'];
        $chat->title = $fromChat['first_name'] ?? null;
        $chat->name = $fromChat['username'] ?? null;
        $chat->is_all_admins = false;
        $chat->old_chat_id = null;
        $chat->save();

        $chat->users()->sync($user);

        return $chat;
    }

    /**
     * @param array $request
     * @param TelegramUser $user
     * @param Chat $chat
     */
    private function saveMessage(array $request, TelegramUser $user, Chat $chat)
    {
        if (isset($request['message']['entities'])) {
            if ($request['message']['entities']['type'] === 'bot_command') {
                return $this->saveBotCommand($request, $user, $chat);
            }
        }

        return $this->saveTextMessage($request, $user, $chat);
    }

    /**
     * @param array $request
     * @param TelegramUser $user
     * @param Chat $chat
     */
    private function saveBotCommand(array $request, TelegramUser $user, Chat $chat)
    {
        $messageType = MessageType::query()->find(MessageType::ENTITIES);

        $message = $this->prepareMessageToSave($request, $user, $chat);
        $message->messageType()->sync($messageType);
        $message->save();
    }

    /**
     * @param array $request
     * @param TelegramUser $user
     * @param Chat $chat
     */
    private function saveTextMessage(array $request, TelegramUser $user, Chat $chat)
    {
        $messageType = MessageType::query()->find(MessageType::ENTITIES);

        $message = $this->prepareMessageToSave($request, $user, $chat);
        $message->messageType()->sync($messageType);
        $message->save();
    }

    /**
     * @param array $request
     * @param TelegramUser $user
     * @param Chat $chat
     * @return InboundMessage
     */
    private function prepareMessageToSave(array $request, TelegramUser $user, Chat $chat)
    {
        $message = new InboundMessage();
        $message->chat_id = $chat->id;
        $message->user_id = $user->id;
        $message->message_text = $request['message']['text'];

        return $message;
    }
}