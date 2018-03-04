<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\TextResponses;

use App\Bot\ResponseMessages\Interfaces\Text;

/**
 * Class FacebookSetter
 *
 * @package App\Bot\ResponseMessages\TextResponses
 */
class FacebookSetter implements Text
{

    /**
     * @return array
     */
    public function prepare(): array
    {
        return [];
    }
}