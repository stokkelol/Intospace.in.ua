<?php
declare(strict_types=1);

namespace App\Bot\Buttons;

use App\Models\OutboundMessage;

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
     * @param OutboundMessage $response
     */
    public function __construct(OutboundMessage $response)
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    abstract public function prepare(): array;
}