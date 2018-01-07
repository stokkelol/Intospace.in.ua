<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\TextResponses;

use App\Bot\ResponseMessages\Interfaces\Text;

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