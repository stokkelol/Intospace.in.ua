<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Bot\Bot;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Message;
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
     * @param Bot $bot
     */
    public function __construct(Api $telegram, Bot $bot)
    {
        $this->telegram = $telegram;
        $this->bot = $bot;
    }


    /**
     * @return User
     */
    public function init(): User
    {
        return $this->telegram->getMe();
    }

    /**
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function setWebhook(): bool
    {
        $this->telegram->setWebhook([
            'url' => 'https://www.intospace.in.ua/telegram/' . config('telegram.bot_token') . '/webhook'
        ]);

        return true;
    }

    /**
     * @param Request $request
     */
    public function processWebhook(Request $request)
    {
        $result = $request->input();
        \logger('message', $request->input());

        return $this->bot->processWebhook($result);
    }
}
