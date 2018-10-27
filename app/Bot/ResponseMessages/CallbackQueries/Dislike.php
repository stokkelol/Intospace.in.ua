<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackQueries;

/**
 * Class Dislike
 *
 * @package App\Bot\ResponseMessages\CallbackQueries
 */
class Dislike extends Query
{
    const FIELD = 'is_disliked';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->save(self::FIELD);
    }
}