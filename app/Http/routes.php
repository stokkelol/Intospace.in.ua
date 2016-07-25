<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

/**
 * Routes for frontend
 */
Route::get('/', 'MainController@index');

Route::get('/posts/{slug}', [
    'as'    =>  'posts',
    'uses'  =>  'PostController@show'
]);

Route::get('/posts', 'PostController@index');

Route::get('/videos', 'VideoController@index');

Route::get('/newsfeed', 'NewsfeedController@index');

Route::get('/blog', 'BlogController@index');

Route::get('/shortreviews', 'ShortReviewController@index');

Route::get('/search', 'SearchController@index');

Route::get('/videos/{slug}', [
    'as'    =>  'videos',
    'uses'  =>  'VideoController@video'
]);

Route::get('/tags/{slug}', [
    'as'    =>  'tags',
    'uses'  =>  'TagController@show'
]);

Route::get('/categories/{slug}', [
    'as'    =>  'categories',
    'uses'  =>  'CategoryController@show'
]);

Route::get('/home', 'HomeController@index');

Route::get('/feed', 'FeedController@feed');

Route::get('/sitemap', 'SitemapController@sitemap');

Route::get('/bands', 'BandController@index');

Route::get('/bands/{slug}', [
    'as'    =>  'bands',
    'uses'  =>  'BandController@show'
]);

Route::get('/profile', 'UserController@show');

/**
 * Routes for backend
 */

Route::group(['prefix' => 'backend', 'middleware' => ['role:admin|owner|demo']], function () {

    Route::get('/', [
        'as'    =>  'backend.index',
        'uses'  =>  'Backend\BackendController@index',
    ]);

    Route::get('/posts/updateall', [
        'as'    =>  'backend.posts.updateall',
        'uses'  =>  'Backend\PostController@getAllUpdated'
    ]);

    Route::resource('posts', 'Backend\PostController');

    Route::get('/posts/preview{post_id}', [
        'as'    =>  'backend.posts.post-preview',
        'uses'  =>  'Backend\PostController@postPreviewOnAjaxRequest'
    ]);

    Route::get('/posts/to-draft/{post_id}', [
        'as'    => 'backend.posts.to-draft',
        'uses'  =>  'Backend\PostController@toDraft'
    ]);

    Route::get('/posts/to-active/{post_id}', [
       'as'     =>  'backend.posts.to-active',
       'uses'  =>  'Backend\PostController@toActive'
    ]);

    Route::get('/posts/to-deleted/{post_id}', [
       'as'     =>  'backend.posts.to-deleted',
       'uses'   =>  'Backend\PostController@toDeleted'
    ]);

    Route::get('/posts/to-pinned/{post_id}',[
        'as'    =>  'backend.posts.to-pinned',
        'uses'  =>  'Backend\PostController@toPinned'
    ]);

    Route::get('/posts/to-regular/{post_id}',[
        'as'    =>  'backend.posts.to-regular',
        'uses'  =>  'Backend\PostController@toRegular'
    ]);


    Route::get('/posts/search/', [
      'as'    =>  'backend.posts.search',
      'uses'  =>  'Backend\PostController@index'
    ]);

    Route::resource('categories', 'Backend\CategoryController');

    Route::resource('tags', 'Backend\TagController');

    Route::resource('users', 'Backend\UserController');

    Route::resource('videos', 'Backend\VideoController');

    Route::resource('bands', 'Backend\BandController');

    Route::resource('blogs', 'Backend\BlogController');

    Route::resource('monthlyreviews', 'Backend\MonthlyReviewController');

    Route::get('posts.set-category/{post_id}/{category_id}', [
        'as'    =>  'backend.post.to.category',
        'uses'  =>  'Backend\PostController@setCategory'
    ]);
});

Route::get('pages/{page_title}', 'PageController@index');
