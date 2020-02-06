<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Bot\Broadcast\Morning;
use App\Models\Chat;
use App\Models\ChatUser;
use Illuminate\Console\Command;

/**
 * Class SendMorningMessage
 *
 * @package App\Console\Commands
 */
class SendMorningMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:morning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send morning message';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function handle(): void
    {
        (new Morning(Chat::query()->with("users")->whereIn("id", ChatUser::query()
            ->where("active", true)
            ->pluck("chat_id")->toArray())
            ->get())
        )->handle();
    }
}
