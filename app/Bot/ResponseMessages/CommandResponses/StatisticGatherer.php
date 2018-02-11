<?php
declare(strict_types=1);

namespace app\Bot\ResponseMessages\CommandResponses;

use App\Models\BandTelegramUser;
use App\Models\Post;
use App\Models\Tag;
use App\Models\TagTelegramUser;
use App\Models\TelegramUser;

/**
 * Class StatisticGatherer
 *
 * @package app\Bot\ResponseMessages\CommandResponses
 */
class StatisticGatherer
{
    /**
     * @param Post $post
     * @param TelegramUser $user
     */
    public function associatePostAndUser(Post $post, TelegramUser $user): void
    {
        $pivot = new BandTelegramUser();
        $pivot->user_id = $user->id;
        $pivot->band_id = $post->band_id;
        $pivot->value++;
        $pivot->save();
    }

    /**
     * @param Post $post
     * @param TelegramUser $user
     */
    public function associateTagAndUser(Post $post, TelegramUser $user): void
    {
        $tags = $post->tags;

        foreach ($tags as $tag) {
            $pivot = TagTelegramUser::query()->where('user_id', $user->id)
                    ->where('tag_id', $tag->id)->first() ?? new TagTelegramUser();
            $pivot->user_id = $user->id;
            $pivot->tag_id = $tag->id;
            $pivot->value++;
            $pivot->save();
        }
    }
}