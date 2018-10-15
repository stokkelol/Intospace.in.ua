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
     * @return \App\Bot\ResponseMessages\Interfaces\Callback
     */
    public static function build(int $type, array $data): Callback
    {
        $class = self::$map[$type];

        return new $class($data);
    }
}