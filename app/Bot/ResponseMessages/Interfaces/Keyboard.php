<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\Interfaces;

use App\Models\OutboundMessageText;

/**
 * Interface Keyboard
 *
 * @package App\Bot\ResponseMessages\Interfaces
 */
interface Keyboard
{
    public function prepare(OutboundMessageText $response): array;
}