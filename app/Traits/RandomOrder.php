<?php
declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Facades\DB;

/**
 * Trait RandomOrder
 *
 * @package app\Traits
 */
trait RandomOrder
{
    /**
     * @param string $tableName
     * @return \stdClass
     */
    public function getRandom(string $tableName): \stdClass
    {
        $result = DB::select('SELECT * FROM ' . $tableName .
            ' JOIN (SELECT RAND() * (SELECT MAX(id) FROM ' . $tableName . ') AS max_id) as m
            WHERE ' . $tableName . '.id >= m.max_id
            ORDER BY ' . $tableName . '.id ASC
            LIMIT 1');

        return $result[0];
    }
}