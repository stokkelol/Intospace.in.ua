<?php
declare(strict_types=1);

namespace app\Bot\ResponseMessages\TextResponses;

use app\Bot\ResponseMessages\Interfaces\Text;

/**
 * Class Unknown
 *
 * @package app\Bot\ResponseMessages\TextResponses
 */
class Unknown implements Text
{
    /**
     * @return array
     */
    public function prepare(): array
    {
        return ['Silence is golden'];
    }
}