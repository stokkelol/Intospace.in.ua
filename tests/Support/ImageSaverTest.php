<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Support\Images\ImageSaver;

class ImageSaverTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testImageSaving()
    {
        $path = 'upload/covers';
        $filename = 'file';
        $image = new ImageSaver;
        $image->save($path, $filename);
    }
}
