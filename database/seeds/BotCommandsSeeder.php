<?php
declare(strict_types=1);

use App\Models\BotCommand;
use Illuminate\Database\Seeder;

/**
 * Class BotCommandsSeeder
 */
class BotCommandsSeeder extends Seeder
{
    /**
     * @var BotCommand
     */
    protected $command;

    /**
     * BotCommandsSeeder constructor.
     *
     * @param BotCommand $command
     */
    public function __construct(BotCommand $command)
    {
        $this->command = $command;
    }
    /**
     * @var array
     */
    private $map = [
        '/latest'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->map as $command) {
            if (!$this->command->where('title', '=', $command)->exists()) {
                $this->command->title = $command;
                $this->command->save();
            }
        }
    }
}
