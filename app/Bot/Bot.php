<?php
declare(strict_types=1);

namespace App\Bot;

use App\Bot\ResponseMessages\CallbackQueries\Factory;
use App\Bot\ResponseMessages\Response;
use App\Bot\Wrappers\CallbackWrapper;
use App\Models\BotCommand;
use App\Models\BotCommandMessage;
use App\Models\Chat;
use App\Models\InboundMessage;
use App\Models\MessageType;
use App\Models\TelegramUser;
use App\Notifications\IncomingTelegramBotMessage;
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
    public function __construct(Api $telegram, TelegramUser $user, Chat $chat)
    {
        $this->telegram = $telegram;
        $this->user = $user;
        $this->chat = $chat;
    }

    /**
     * @param array $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed
     */
    public function processWebhook(array $request)
    {
        if (InboundMessage::query()->where('id', '=', $request['update_id'])->exists()) {
            return \response('', 204);
        }

        [$user, $chat, $messageType] = $this->processInitialRequest($request);

        $message = Response::factory($messageType->id, $this->telegram);
        $message->setParameters($request, $chat, $user);


        try {
            $message->sendResponse();
        } catch (\Throwable $e) {
            \logger($e);
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    private function processInitialRequest($request): array
    {
        if (isset($request['message'])) {
            return $this->processMessage($request);
        }

        if (isset($request['callback_query'])) {
            return $this->processCallback($request);
        }

        return [];
    }

    /**
     * @param $request
     * @return array
     */
    private function processCallback($request): array
    {
        $from = $request['callback_query']['from'];
        $fromChat = $request['callback_query']['message']['chat'];

        $user = $this->user->where('id', $from['id'])->first();
        $chat = $this->chat->where('id', $fromChat['id'])->first();

        $this->processCallbackData($request);

        /** @var MessageType $messageType */
        $messageType = $this->saveCallbackMessage($request, $user, $chat);

        return [$user, $chat, $messageType];
    }

    private function processCallbackData($request): void
    {
        $data = \json_decode($request['callback_query']['data'], true);
        $handler = Factory::build($data['callback_type'], $data);
        $handler->handle();
    }

    /**
     * @param $request
     * @return array
     */
    private function processMessage($request): array
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
        $user->chats()->update(['active' => true]);


        $messageType = $this->saveMessage($request, $user, $chat);

        return [$user, $chat, $messageType];
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
     * @return Bot|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static[]
     */
    private function saveMessage(array $request, TelegramUser $user, Chat $chat)
    {
        $message = $this->isHandled($request);

        if ($message !== null) {
            return $message->messageType;
        }

        $user->notify(new IncomingTelegramBotMessage($request['message']['text']));
        if (isset($request['message']['entities'])) {
            if ($request['message']['entities'][0]['type'] === 'bot_command') {
                return $this->saveBotCommand($request, $user, $chat);
            }
        }

        return $this->saveTextMessage($request, $user, $chat);
    }

    /**
     * @param array $request
     * @param TelegramUser $user
     * @param Chat $chat
     * @return MessageType
     */
    private function saveBotCommand(array $request, TelegramUser $user, Chat $chat): MessageType
    {
        /** @var MessageType $messageType */
        $messageType = MessageType::query()->find(MessageType::ENTITIES);

        $command = BotCommand::query()->where('title', '=', $request['message']['text'])->first();

        $message = $this->prepareMessageToSave($request, $user, $chat);
        $message->messageType()->associate($messageType);
        $message->save();

        $pivot = new BotCommandMessage();
        $pivot->inbound_message_id = $request['update_id'];
        $pivot->bot_command_id = $command->id;
        $pivot->save();

        return $messageType;
    }

    /**
     * @param array $request
     * @param TelegramUser $user
     * @param Chat $chat
     * @return MessageType
     */
    private function saveTextMessage(array $request, TelegramUser $user, Chat $chat): MessageType
    {
        /** @var MessageType $messageType */
        $messageType = MessageType::query()->find(MessageType::TEXT);

        $message = $this->prepareMessageToSave($request, $user, $chat);
        $message->messageType()->associate($messageType);
        $message->save();

        return $messageType;
    }

    /**
     * @param array $request
     * @param TelegramUser $user
     * @param Chat $chat
     * @return MessageType
     */
    private function saveCallbackMessage(array $request, TelegramUser $user, Chat $chat): MessageType
    {
        $message = InboundMessage::query()->where('id', $request['update_id'])->first();

        if ($message !== null) {
            return $message->messageType;
        }

        $this->notifyCallback($user, $request);
        // we need to answer to callback as soon as possible
        $this->sendOk($request);

        /** @var MessageType $messageType */
        $messageType = MessageType::query()->find(MessageType::CALLBACK);

        $message = $this->prepareMessageToSave($request, $user, $chat);
        $message->messageType()->associate($messageType);
        $message->save();

        return $messageType;
    }

    /**
     * @param array $request
     * @param TelegramUser $user
     * @param Chat $chat
     * @return InboundMessage
     */
    private function prepareMessageToSave(array $request, TelegramUser $user, Chat $chat): InboundMessage
    {
        $message = new InboundMessage();
        $message->id = $request['update_id'];
        $message->chat_id = $chat->id;
        $message->user_id = $user->id;
        $message->message_text = $request['message']['text'] ?? '';

        return $message;
    }

    /**
     * @param TelegramUser $user
     * @param array $request
     */
    private function notifyCallback(TelegramUser $user, array $request): void
    {
        $user->notify(new IncomingTelegramBotMessage("New callback response! From " .
            $user->user_name . ". Data: " . $request['callback_query']['data']));
    }

    /**
     * @param array $request
     */
    private function sendOk(array $request): void
    {
        $client = new CallbackWrapper($this->telegram, $request);
        $client->send();
    }

    /**
     * @param array $request
     * @return InboundMessage|null
     */
    private function isHandled(array $request): ?InboundMessage
    {
        return InboundMessage::query()->where('id', $request['update_id'])->first();
    }
}