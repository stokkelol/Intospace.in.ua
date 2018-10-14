<?php
declare(strict_types=1);

namespace App\Bot\Keyboard;

use App\Bot\Buttons\BaseButton;
use App\Bot\Buttons\Factory;
use App\Bot\ResponseMessages\Interfaces\Keyboard;
use App\Models\OutboundMessageText;

/**
 * Class Base
 *
 * @package App\Bot\Keyboard
 */
class Base implements Keyboard
{
    /**
     * @param OutboundMessageText $response
     * @return array
     */
    public function prepare(OutboundMessageText $response): array
    {
        $res = [];

        /** @var BaseButton $button */
        foreach ($this->map() as $button) {
            $res[] = (new $button)->prepare($response);
        }

        return $res;
    }

    /**
     * @return array
     */
    public function map(): array {
        return Factory::map();
    }
}