<?php
declare(strict_types=1);

namespace App\Bot\Buttons;

use App\Models\OutboundMessageText;

/**
 * Class BaseButton
 *
 * @package App\Bot\Buttons
 */
abstract class BaseButton
{
    /**
     * @var array
     */
    protected $response;

    /**
     * BaseButton constructor.
     *
     * @param OutboundMessageText $response
     */
    public function __construct(OutboundMessageText $response)
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    abstract public function prepare(): array;
}