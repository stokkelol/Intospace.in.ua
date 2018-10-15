<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackQueries;

use App\Bot\ResponseMessages\Interfaces\Callback;

/**
 * Class Query
 *
 * @package App\Bot\ResponseMessages\CallbackQueries
 */
abstract class Query implements Callback
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Query constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
}