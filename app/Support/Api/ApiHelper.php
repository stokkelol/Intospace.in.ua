<?php
declare(strict_types=1);

namespace App\Support\Api;

/**
 * Class ApiHelper
 *
 * @package App\Support\Api
 */
class ApiHelper
{

    public static function respond($data, array $headers = [], $statusCode = false, $rootWrapper = 'results')
    {
        if ($statusCode !== false) {
            $code = $statusCode;
        } else {
            $code = 200;
        }

        return response()->json([
            $rootWrapper => $data,
        ], $code, $headers);
    }
}