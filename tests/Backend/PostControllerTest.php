<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class PostControllerTest extends TestCase
{

    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $user = User::findOrFail(1);
        Auth::login($user);
    }

    public function testPostsIndexPage()
    {
        $this->visit('backend')
             ->click('Posts')
             ->see('Posts');
    }

    public function testStoreMethod()
    {
        $this->visit('backend')
             ->click('Posts')
             ->see('Create post')
             ->click('Create post')
             ->see('New post')
             ->type('Title', 'title')
             ->select('1', 'band_id')
             ->type('excerpt', 'excerpt')
             ->type('text', 'content')
             ->type('links', 'links')
             ->type('youtube', 'video')
             ->type('similars', 'similar')
             ->select('1', 'category_id')
             ->select('2', 'tagList[]')
             ->attach('public/covers/cover.jpg', 'img')
             ->attach('public/logos/logo.jpg', 'logo')
             ->type('2016-01-01 12:00:00', 'published_at');
    }
}
