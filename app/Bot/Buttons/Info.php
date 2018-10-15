<?php
declare(strict_types=1);

namespace App\Bot\Buttons;

/**
 * Class Info
 *
 * @package App\Bot\Keyboard
 */
class Info extends BaseButton
{
    /**
     * @return array
     */
    public function prepare(): array
    {
        return [
            'text' => "🤔 Info",
            'callback_data' => \json_encode([
                'callback_type' => 3,
                'id' => $this->response['id']
            ])
        ];
    }
}