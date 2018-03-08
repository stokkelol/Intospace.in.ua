<?php

namespace App\Console\Commands;

use App\Models\Band;
use App\Models\Post;
use Illuminate\Console\Command;

class UpdateBandPostExist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:band_post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var Band[] $bands */
        $bands = Band::query()->where('is_post_exist', '=', false)->get();

        foreach ($bands as $band) {
            if (Post::query()->where('band_id', '=', $band->id)->exists()) {
                $band->is_post_exist = true;
                $band->save();
            }
        }
    }
}
