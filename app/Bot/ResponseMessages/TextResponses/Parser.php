<?php
declare(strict_types=1);

namespace app\Bot\ResponseMessages\TextResponses;

use App\Bot\Lastfm\Lastfm;
use App\Bot\ResponseMessages\Interfaces\Text;
use App\Bot\ResponseMessages\TextResponse;
use App\Models\Social;
use App\Models\SocialTelegramUser;
use Illuminate\Container\Container;

/**
 * Class Parser
 * 
 * @package app\Bot\ResponseMessages\TextResponses
 */
class Parser
{
    const SEPARATOR  = '#';

    const BASE_PATTERN = '';

    /**
     * @var array
     */
    private $parts = [];

    /**
     * @var Text
     */
    private $response;

    /**
     * Parser constructor.
     * 
     * @param TextResponse $response
     */
    public function __construct(TextResponse $response)
    {
        $this->response = $response;
    }

    /**
     * @return Text
     */
    public function parse(): Text
    {
        if (\mb_strpos(self::SEPARATOR, $this->response->getText())) {
            return new Unknown();
        }

        $parts = \explode(self::SEPARATOR, $this->response->getText());

        $this->parts = $parts;

        if (isset($this->parts[0], $this->parts[1])) {
            if ($this->parts[0] = 'lastfm') {
                return $this->tryAssociateLastfm($this->parts[1]);
            }
        }
    }

    /**
     * @return Lastfm
     */
    private function makeLastFmHandler(): Lastfm
    {
        return Container::getInstance()->make(Lastfm::class);
    }

    private function tryAssociateLastfm(string $lastfmTag)
    {
        $apiHandler = $this->makeLastFmHandler();

        $apiHandler->getUserInfo($lastfmTag);
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