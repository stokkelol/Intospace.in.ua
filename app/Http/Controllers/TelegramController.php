<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Telegram\Bot\Api;

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
    protected $telegram;

    /**
     * TelegramController constructor.
     *
     * @param Api $telegram
     */
    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }


    public function init()
    {
        $response = $this->telegram->getMe();
        dd($response);
        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUserName();
    }
}
