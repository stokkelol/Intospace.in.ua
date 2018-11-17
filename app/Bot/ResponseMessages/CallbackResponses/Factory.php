<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackResponses;

use App\Bot\ResponseMessages\Interfaces\CallbackResponse;

/**
 * Class Factory
 *
 * @package App\Bot\ResponseMessages\CallbackResponses
 */
final class Factory
{
    /**
     * @var array
     */
    private static $responses = [
        \App\Bot\Buttons\Factory::LikeButton => Like::class,
        \App\Bot\Buttons\Factory::DislikeButton => Dislike::class,
        \App\Bot\Buttons\Factory::InfoButton => More::class,
        \App\Bot\Buttons\Factory::MoreButton => Info::class,
    ];

    /**
     * @param int $type
     * @param array $data
     * @return CallbackResponse
     */
    public static function build(int $type, array $data): CallbackResponse
    {
        return new self::$responses[$type]($data);
    }
}