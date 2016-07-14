<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class SaveVideoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSaveVideo()
    {
        $user = User::findOrFail(1);
        Auth::login($user);

        $this->visit('/backend')
             ->see('Dashboard')
             ->click('Videos')
             ->see('Videos')
             ->click('Create video')
             ->see('Title');
    }
}
