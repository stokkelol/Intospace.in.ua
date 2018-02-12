<?php
declare(strict_types=1);

namespace App\Bot\Jobs;

use App\Models\TelegramUser;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class MorningMessage
 *
 * @package App\Bot\Jobs
 */
class MorningMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var TelegramUser
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param TelegramUser $user
     */
    public function __construct(TelegramUser $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        //
    }
}
