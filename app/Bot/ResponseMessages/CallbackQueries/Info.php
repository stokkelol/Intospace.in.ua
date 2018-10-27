<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackQueries;

/**
 * Class Info
 *
 * @package App\Bot\ResponseMessages\CallbackQueries
 */
class Info extends Query
{
    const FIELD = 'info';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->save(self::FIELD);
    }
}