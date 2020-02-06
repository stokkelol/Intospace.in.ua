<?php
declare(strict_types=1);

namespace App\Bot\Buttons;

/**
 * Class Incorrect
 *
 * @package App\Bot\Buttons
 */
class Incorrect extends BaseButton
{
    /**
     * @inheritDoc
     */
    public function prepare(): array
    {
        return [
            'text' => "Incorrect!",
            'callback_data' => \json_encode([
                'callback_type' => Factory::IncorrectButton,
                'id' => $this->response['id']
            ])
        ];
    }
}