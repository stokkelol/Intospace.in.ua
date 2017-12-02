<?php
declare(strict_types=1);

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class MessageTypesSeeder
 */
class MessageTypesSeeder extends Seeder
{
    /**
     * @var array
     */
    protected $map = [
        'text',
        'entities',
        'audio',
        'document',
        'photo',
        'sticker',
        'video',
        'voice',
        'video_note',
        'contact',
        'location',
        'venue',
        'caption'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->map as $value) {
            DB::table('message_types')->insert([
                'title' => $value,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
