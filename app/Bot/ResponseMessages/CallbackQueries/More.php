<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackQueries;

/**
 * Class More
 *
 * @package App\Bot\ResponseMessages\CallbackQueries
 */
class More extends Query
{
    const FIELD = 'more';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->save(self::FIELD);
    }
}