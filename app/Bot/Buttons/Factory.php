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
    const DislikeButton = 2;
    const InfoButton = 3;
    const MoreButton = 4;
    const IncorrectButton = 5;

    /**
     * @var array
     */
    private static $buttons = [
        self::LikeButton => Like::class,
        self::DislikeButton => Dislike::class,
        self::InfoButton => More::class,
        self::MoreButton => Info::class,
        self::IncorrectButton => Incorrect::class,
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