<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\TextResponses;

use App\Bot\Interfaces\ResponseMessage;
use App\Bot\Lastfm\Lastfm;
use App\Models\Social;
use App\Models\SocialTelegramUser;
use App\Models\TelegramUser;
use App\Support\Logger\Logger;
use Illuminate\Container\Container;

/**
 * Class Setter
 *
 * @package App\Bot\ResponseMessages\TextResponses
 */
abstract class Setter
{
    /**
     * @var string
     */
    protected $nickname;

    /**
     * @var ResponseMessage
     */
    protected $response;

    /**
     * LastFmSetter constructor.
     *
     * @param string $nickname
     * @param ResponseMessage $response
     */
    public function __construct(string $nickname, ResponseMessage $response)
    {
        $this->nickname = $nickname;
        $this->response = $response;
    }

    /**
     * @return array
     */
    public function prepare(): array
    {
        return $this->associate();
    }

    /**
     * @return array
     */
    abstract protected function associate(): array;

    /**
     * @return string
     */
    abstract protected function getHandlerType(): string;

    /**
     * @return Lastfm
     */
    protected function makeHandler(): Lastfm
    {
        return Container::getInstance()->make($this->getHandlerType());
    }

    /**
     * @param TelegramUser $user
     * @param int $type
     * @param string $nickname
     * @return bool
     */
    protected function save(TelegramUser $user, int $type, string $nickname): bool
    {
        try {
            $social = Social::query()->find($type);
            $userSocial = new SocialTelegramUser();
            $userSocial->user_id = $user->id;
            $userSocial->social_id = $social->id;
            $userSocial->value = $nickname;
            $userSocial->save();
        } catch (\Throwable $e) {
            Logger::exception($e);

            return false;
        }

        return true;
    }
}