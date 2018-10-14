<?php
declare(strict_types=1);

namespace App\Bot\Keyboard;

use App\Bot\Buttons\BaseButton;
use App\Bot\Buttons\Factory;
use App\Bot\ResponseMessages\Interfaces\Keyboard;

/**
 * Class Base
 *
 * @package App\Bot\Keyboard
 */
class Base implements Keyboard
{
    /**
     * @return array
     */
    public function prepare(): array
    {
        $response = [];

        /** @var BaseButton $button */
        foreach ($this->map() as $button) {
            $response[] = (new $button)->prepare();
        }

        return $response;
    }

    /**
     * @return array
     */
    public function map(): array {
        return Factory::map();
    }
}