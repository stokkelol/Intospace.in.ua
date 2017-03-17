<?php

namespace App\Support\Logger;

use Exception;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class Logger
{
    /**
     * @param Exception $e
     */
    public static function exception(Exception $e)
    {
        Log::debug(get_class($e) . ' has been thrown with message: "' . $e->getMessage() . '" in file: ' . $e->getFile()
            . ' at line: ' . $e->getLine() . '. Trace:' . $e->getTraceAsString());
    }

    /**
     * @param ResponseInterface $response
     */
    public static function httpClientError(ResponseInterface $response)
    {
        Log::debug('Http error, code:' . $response->getStatusCode() . ', body: ' . $response->getBody());
    }
}