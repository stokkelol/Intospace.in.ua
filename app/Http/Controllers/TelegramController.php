<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Bot\Bot;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\User;

/**
 * Class TelegramController
 *
 * @package App\Http\Controllers
 */
class TelegramController extends Controller
{
    /**
     * @var Api
     */
    private $telegram;

    /**
     * @var Bot
     */
    private $bot;

    /**
     * TelegramController constructor.
     *
     * @param Api $telegram
     */
    public function __construct(Api $telegram, Bot $bot)
    {
        $this->telegram = $telegram;
        $this->bot = $bot;
    }


    /**
     * @return User
     */
    public function init()
    {
        return $this->telegram->getMe();
    }

    public function setWebhook()
    {
        $response = $this->telegram->setWebhook([
            'url' => 'https://www.intospace.in.ua/telegram/' . config('telegram.bot_token') . '/webhook'
        ]);

        print_r($response);

        return;
    }

    public function processWebhook(Request $request)
    {
        $result = $request->input();

        \logger('message', $result);

//        return $this->telegram->sendMessage([
//            'chat_id' => $result->message->chat->id,
//            'text' => 'Hi!'
//        ]);
    }
}
