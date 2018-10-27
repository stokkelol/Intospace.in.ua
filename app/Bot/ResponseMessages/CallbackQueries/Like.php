<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackQueries;

/**
 * Class Like
 *
 * @package App\Bot\ResponseMessages\CallbackQueries
 */
class Like extends Query
{
    const FIELD = 'is_liked';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->save(self::FIELD);
    }
}