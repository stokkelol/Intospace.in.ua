<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use App;
use URL;
use DB;

class SitemapController extends Controller
{
    public function sitemap()
    {
        // create new sitemap object
        $sitemap = App::make("sitemap");

        // set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
        // by default cache is disabled
        $sitemap->setCache('laravel.sitemap', 60);

        // check if there is cached sitemap and build new only if is not
        if (!$sitemap->isCached())
        {
            // add item to the sitemap (url, date, priority, freq)
            $sitemap->add(URL::to('/'), '2012-08-25T20:10:00+02:00', '1.0', 'daily');
            //$sitemap->add(URL::to('page'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');

            /*// add item with translations (url, date, priority, freq, images, title, translations)
            $translations = [
                ['language' => 'fr', 'url' => URL::to('pageFr')],
                ['language' => 'de', 'url' => URL::to('pageDe')],
                ['language' => 'bg', 'url' => URL::to('pageBg')],
            ];
            $sitemap->add(URL::to('pageEn'), '2015-06-24T14:30:00+02:00', '0.9', 'monthly', [], null, $translations);
            */
            /*// add item with images
            $images = [
                ['url' => URL::to('images/pic1.jpg'), 'title' => 'Image title', 'caption' => 'Image caption', 'geo_location' => 'Plovdiv, Bulgaria'],
                ['url' => URL::to('images/pic2.jpg'), 'title' => 'Image title2', 'caption' => 'Image caption2'],
                ['url' => URL::to('images/pic3.jpg'), 'title' => 'Image title3'],
            ];
            $sitemap->add(URL::to('post-with-images'), '2015-06-24T14:30:00+02:00', '0.9', 'monthly', $images);
            */

            // get all posts from db
            $posts = DB::table('posts')->orderBy('published_at', 'desc')->get();

            // add every post to the sitemap
            foreach ($posts as $post)
            {
                $sitemap->add($post->slug, $post->published_at, '1.0', 'daily');
            }

            $videos = DB::table('videos')->orderBy('published_at', 'desc')->get();

            foreach ($videos as $video)
            {
                $sitemap->add($video->slug, $video->published_at, '0.9', 'daily');
            }
        }

        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap->render('xml');
    }
}
