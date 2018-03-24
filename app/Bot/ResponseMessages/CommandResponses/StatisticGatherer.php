<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CommandResponses;

use App\Bot\Jobs\MorningMessage;
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
     * @var Post|null
     */
    private $post;
    /**
     * @var TelegramUser
     */
    private $user;
    /**
     * @var TelegramUserRecommendation|null
     */
    private $recommendation;

    /**
     * StatisticGatherer constructor.
     *
     * @param Post|null $post
     * @param TelegramUser $user
     * @param TelegramUserRecommendation|null $recommendation
     */
    public function __construct(TelegramUser $user, ?Post $post,?TelegramUserRecommendation $recommendation)
    {
        $this->post = $post;
        $this->user = $user;
        $this->recommendation = $recommendation;
    }

    /**
     * @param Post|null $post
     * @param TelegramUser $user
     * @param TelegramUserRecommendation|null $recommendation
     * @return StatisticGatherer
     */
    public static function createFromQueue(TelegramUser $user, ?Post $post, ?TelegramUserRecommendation $recommendation): self
    {
        return new static($post, $user, $recommendation);
    }

    /**
     * @param Post|null $post
     * @param TelegramUser $user
     * @return StatisticGatherer
     */
    public static function createFromCommand( TelegramUser $user, ?Post $post): self
    {
        return new static($post, $user, null);
    }

    /**
     * @return StatisticGatherer
     */
    public function associateBandAndUser(): self
    {
        $id = $this->post === null ? $this->recommendation->band_id : $this->post->band_id;

        $pivot = $this->findBandUserPivot($id);
        $pivot->value++;
        $pivot->save();

        return $this;
    }

    /**
     * @return StatisticGatherer
     */
    public function associateTagAndUser(): self
    {
        if ($this->post !== null) {
            foreach ($this->post->tags as $tag) {
                $pivot = $this->findTagUserPivot($tag->id);
                $pivot->value++;
                $pivot->save();
            }
        }

        return $this;
    }

    /**
     * @param int $id
     * @return BandTelegramUser
     */
    private function findBandUserPivot(int $id): BandTelegramUser
    {
        /** @var BandTelegramUser $pivot */
        $pivot = BandTelegramUser::query()->where('band_id', '=', $id)
            ->where('user_id', $this->user->id)->first();

        if ($pivot === null) {
            $pivot = new BandTelegramUser();
            $pivot->user_id = $this->user->id;
            $pivot->band_id = $this->post->band_id;
        }

        return $pivot;
    }

    /**
     * @param int $id
     * @return TagTelegramUser
     */
    private function findTagUserPivot(int $id): TagTelegramUser
    {
        /** @var TagTelegramUser $pivot */
        $pivot = TagTelegramUser::query()->where('user_id', $this->user->id)
                ->where('tag_id', $id)->first();

        if ($pivot === null) {
            $pivot = new TagTelegramUser();
            $pivot->user_id = $this->user->id;
            $pivot->tag_id = $id;
        }

        $pivot->value++;

        return $pivot;
    }
}