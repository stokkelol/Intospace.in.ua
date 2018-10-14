<?php
declare(strict_types=1);

namespace App\Bot\Buttons;

/**
 * Class More
 *
 * @package App\Bot\Keyboard
 */
class More extends BaseButton
{
    /**
     * @return array
     */
    public function prepare(): array
    {
        return [
            'text' => "🤗 More",
            'callback_data' => "id:" . $this->response['id']
        ];
    }
}