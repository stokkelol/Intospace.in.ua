<?php
declare(strict_types=1);

namespace App\Bot\Buttons;

/**
 * Class Dislike
 *
 * @package App\Bot\Keyboard
 */
class Dislike extends BaseButton
{
    /**
     * @return array
     */
    public function prepare(): array
    {
        return [];
    }
}