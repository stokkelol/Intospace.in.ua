<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\Jobs\MorningMessage;
use App\Models\Band;
use App\Models\BandTelegramUser;
use App\Models\Post;
use App\Models\Tag;
use App\Models\TagTelegramUser;
use App\Models\TelegramUser;
use App\Models\TelegramUserRecommendation;

/**
 * Class StatisticGatherer
 *
 * @package app\Bot\ResponseMessages\CommandResponses
 */
class StatisticGatherer
{
    /**
     * @var TelegramUser
     */
    private $user;

    /**
     * StatisticGatherer constructor.
     *
     * @param TelegramUser $user
     */
    public function __construct(TelegramUser $user)
    {
        $this->user = $user;
    }

    /**
     * @param Band $band
     * @return StatisticGatherer
     */
    public function associateBandAndUser(Band $band): self
    {
        $pivot = $this->findBandUserPivot($band);
        $pivot->value++;
        $pivot->save();

        return $this;
    }

    /**
     * @param Band $band
     * @return StatisticGatherer
     */
    public function associateTagAndUser(Band $band): self
    {
        foreach ($band->tags as $tag) {
            $pivot = $this->findTagUserPivot($tag);
            $pivot->value++;
            $pivot->save();
        }

        return $this;
    }

    /**
     * @param Band $band
     * @return BandTelegramUser
     * @internal param int $id
     */
    private function findBandUserPivot(Band $band): BandTelegramUser
    {
        /** @var BandTelegramUser $pivot */
        $pivot = BandTelegramUser::query()->where('band_id', '=', $band->id)
            ->where('user_id', $this->user->id)->first();

        if ($pivot === null) {
            $pivot = new BandTelegramUser();
            $pivot->user_id = $this->user->id;
            $pivot->band_id = $band->id;
        }

        return $pivot;
    }

    /**
     * @param Tag $tag
     * @return TagTelegramUser
     * @internal param int $id
     */
    private function findTagUserPivot(Tag $tag): TagTelegramUser
    {
        /** @var TagTelegramUser $pivot */
        $pivot = TagTelegramUser::query()->where('user_id', $this->user->id)
                ->where('tag_id', $tag->id)->first();

        if ($pivot === null) {
            $pivot = new TagTelegramUser();
            $pivot->user_id = $this->user->id;
            $pivot->tag_id = $tag->id;
        }

        $pivot->value++;

        return $pivot;
    }
}