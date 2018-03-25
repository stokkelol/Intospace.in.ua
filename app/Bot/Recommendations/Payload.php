<?php
declare(strict_types=1);

namespace App\Bot\Recommendations;

/**
 * Class Payload
 *
 * @package App\Bot\Recommendations
 */
class Payload
{
    /**
     * @param array $data
     * @return string
     */
    public function processRecommendation(array $data): string
    {
        return \json_encode([
            'link' => $data[0]->id->videoId
        ]);
    }
}