<?php
declare(strict_types=1);

use App\Models\Social;
use Illuminate\Database\Seeder;

/**
 * Class SocialsSeeder
 */
class SocialsSeeder extends Seeder
{
    /**
     * @var Social
     */
    private $social;

    /**
     * SocialsSeeder constructor.
     *
     * @param Social $social
     */
    public function __construct(Social $social)
    {
        $this->social = $social;
    }

    /**
     * @var array
     */
    private $map = [
        1 => 'lastfm',
        2 => 'facebook'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->map as $k => $v) {
            if ($this->social->where('id', '=', $k)->exists()) {
                $model = $this->social->where('id', '=', $k)->first();
                $model->name = $v;
                $model->save();
            } else {
                $model = new Social();
                $model->name = $v;
                $model->save();
            }
        }
    }
}
