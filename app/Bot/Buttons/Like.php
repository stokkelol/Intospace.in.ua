<?php
declare(strict_types=1);

namespace App\Bot\Buttons;

/**
 * Class Like
 *
 * @package App\Bot\Keyboard
 */
class Like extends BaseButton
{
    /**
     * @return array
     */
    public function prepare(): array
    {
        return [
            'text' => "🤪 Like!",
            'callback_data' => "callback_type:1,". "id:" . $this->response['id']
        ];
    }
}