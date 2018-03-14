<?php
declare(strict_types=1);

namespace App\Support\Logger;

use Exception;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Logger
 *
 * @package App\Support\Logger
 */
class Logger
{
    /**
     * @param string $string
     */
    public static function log(string $string): void
    {
        Log::debug($string);
    }
    
    /**
     * @param \Throwable $e
     */
    public static function exception(\Throwable $e)
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