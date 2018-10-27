<?php
/**
 * Created by PhpStorm.
 * User: alexandergulyiy
 * Date: 10/27/18
 * Time: 3:37 PM
 */

namespace App\Bot\ResponseMessages\CallbackResponses;


use App\Bot\ResponseMessages\Interfaces\CallbackResponse;

abstract class Callback implements CallbackResponse
{
    /**
     * @var
     */
    protected $data;

    /**
     * Callback constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
}