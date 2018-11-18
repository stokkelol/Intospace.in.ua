<?php
declare(strict_types=1);

namespace App\Bot\ResponseMessages\Interfaces;

/**
 * Interface CallbackResponse
 * 
 * @package App\Bot\ResponseMessages\Interfaces
 */
interface CallbackResponse
{
    /**
     * @return void
     */
    public function handle(): void;
}