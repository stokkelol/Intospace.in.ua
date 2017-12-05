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
        1 => '/latest',
        2 => '/blackmetal',
        3 => '/deathmetal',
        4 => '/sludge',
        5 => '/technicaldeathmetal',
        6 => '/sludgedoom',
        7 => '/experimental',
        8 => '/psychedelic',
        9 => '/doommetal'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->map as $k => $v) {
            if (BotCommand::where('id', '=', $k)->exists()) {
                $model = BotCommand::query()->where('id', '=', $k)->first();
                $model->title = $v;
                $model->save();
            } else {
                $model = new BotCommand();
                $model->title = $v;
                $model->save();
            }
        }
    }
}
