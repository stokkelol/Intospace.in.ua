<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackQueries;

use App\Bot\ResponseMessages\Interfaces\Callback;

/**
 * Class Factory
 *
 * @package App\Bot\ResponseMessages\CallbackQueries
 */
class Factory
{
    /**
     * @var array
     */
    public static $map = [
        \App\Bot\Buttons\Factory::LikeButton => Like::class,
        \App\Bot\Buttons\Factory::DislikeButton => Dislike::class,
        \App\Bot\Buttons\Factory::InfoButton => More::class,
        \App\Bot\Buttons\Factory::MoreButton => Info::class,
    ];

    /**
     * @param int $type
     * @param array $data
     * @return callable
     */
    public static function build(int $type, array $data): Callback
    {
        return new self::$map[$type]($data);
    }
}