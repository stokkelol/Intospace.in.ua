<?php
declare(strict_types=1);

namespace app\Bot\ResponseMessages\CommandResponses;

use app\Bot\ResponseMessages\Interfaces\Command;

/**
 * Class Factory
 *
 * @package app\Bot\ResponseMessages\CommandResponses
 */
final class Factory
{
    /**
     * @param string $type
     * @return Command
     */
    public static function build(string $type): Command
    {
        switch ($type) {
            case '\latest':
                return new Latest();
            case '\blackmetal':
                return new BlackMetal();
        }
    }
}