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
     * @var array
     */
    private $map = [
        '/latest',
        '/black_metal',
        '/death_metal',
        '/sludge',
        '/technical_death_metal',
        '/sludge_doom',
        '/experimental',
        '/psychedelic',
        '/doom_metal'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->map as $command) {
            if (!BotCommand::where('title', '=', $command)->exists()) {
                $model = new BotCommand();
                $model->title = $command;
                $model->save();
            }
        }
    }
}
