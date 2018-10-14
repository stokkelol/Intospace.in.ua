<?php
declare(strict_types=1);

namespace App\Bot\Buttons;

/**
 * Class Factory
 *
 * @package App\Bot\Buttons
 */
class Factory
{
    const LikeButton = 1;
    const DislikeButton = 1;
    const InfoButton = 1;
    const MoreButton = 1;

    /**
     * @var array
     */
    private static $buttons = [
        self::LikeButton => \App\Bot\Buttons\Like::class,
        self::DislikeButton => \App\Bot\Buttons\Dislike::class,
        self::InfoButton => \App\Bot\Buttons\More::class,
        self::MoreButton => \App\Bot\Buttons\Info::class,
    ];

    /**
     * @param int $type
     * @return BaseButton
     */
    public static function build (int $type): BaseButton {
        return new self::$buttons[$type];
    }

    /**
     * @return array
     */
    public static function map(): array {
        return self::$buttons;
    }
}