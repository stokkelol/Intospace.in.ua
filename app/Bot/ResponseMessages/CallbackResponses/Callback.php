<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\CallbackResponses;

use App\Bot\ResponseMessages\Interfaces\CallbackResponse;
use App\Bot\ResponseMessages\Response;

/**
 * Class Callback
 *
 * @package App\Bot\ResponseMessages\CallbackResponses
 */
abstract class Callback implements CallbackResponse
{
    /**
     * @var
     */
    protected $data;

    /**
     * @var Response
     */
    protected $response;

    /**
     * Callback constructor.
     *
     * @param array $data
     * @param Response $response
     */
    public function __construct(array $data, Response $response)
    {
        $this->data = $data;
        $this->response = $response;
    }

    /**
     * @return string
     */
    abstract protected function getText(): string;
}