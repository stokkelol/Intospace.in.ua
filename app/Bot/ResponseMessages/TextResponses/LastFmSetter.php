<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\TextResponses;

use App\Bot\Interfaces\ResponseMessage;
use App\Bot\Lastfm\Lastfm;
use App\Bot\ResponseMessages\Interfaces\Text;
use App\Models\Band;
use App\Models\Social;
use App\Models\SocialTelegramUser;
use Illuminate\Container\Container;

/**
 * Class LastFmSetter
 *
 * @package app\Bot\ResponseMessages\TextResponses
 */
class LastFmSetter extends Setter
{
    /**
     * @return string
     */
    protected function getHandlerType(): string
    {
        return Lastfm::class;
    }

    /**
     * @return array
     * @throws \RuntimeException
     */
    protected function associate(): array
    {
        $apiHandler = $this->makeHandler();
        $apiHandler->getUserInfo($this->nickname);
        $response = $apiHandler->get();
        $user = $this->response->getUser();

        if (!$user->whereHas('socials', function ($query) {
            $query->where('social_id', Social::LASTFM);
        })->exists()) {
            if ($this->save($user, Social::LASTFM, $nickname = $response['user']['name'])) {
                return ['Hey ho ' . $nickname . '!'];
            }

            return ['Oops! Something went wrong on my side! Please try again later!'];
        }

        return ['Hi again!'];
    }
}