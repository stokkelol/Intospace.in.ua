<?php
declare(strict_types=1);

namespace app\Bot\ResponseMessages\TextResponses;
use App\Bot\Interfaces\ResponseMessage;
use App\Bot\Lastfm\Lastfm;
use App\Bot\ResponseMessages\Interfaces\Text;
use App\Models\Social;
use App\Models\SocialTelegramUser;
use Illuminate\Container\Container;

/**
 * Class LastFmSetter
 *
 * @package app\Bot\ResponseMessages\TextResponses
 */
class LastFmSetter implements Text
{
    /**
     * @var string
     */
    private $nickname;

    /**
     * @var ResponseMessage
     */
    private $response;

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
        $this->tryAssociateLastfm();
    }

    /**
     * @return Lastfm
     */
    private function makeLastFmHandler(): Lastfm
    {
        return Container::getInstance()->make(Lastfm::class);
    }

    private function tryAssociateLastfm()
    {
        $apiHandler = $this->makeLastFmHandler();

        $apiHandler->getUserInfo($this->nickname);
        $response = $apiHandler->get();

        $nickname = $response['user']['name'];
        $user = $this->response->getUser();
        if (!$user->whereHas('socials', function ($query) {
            $query->where('id', Social::LASTFM);
        })->exists()) {
            $social = Social::query()->find(Social::LASTFM);
            $userSocial = new SocialTelegramUser();
            $userSocial->user_id = $user->id;
            $userSocial->social_id = $social->id;
            $userSocial->value = $nickname;
            $userSocial->save();

            return ['Hey ho ' . $nickname . '!'];
        }
    }
}