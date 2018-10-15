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
            'callback_data' => \json_encode([
                'callback_type' => 4,
                'id' => $this->response['id']
            ])
        ];
    }
}