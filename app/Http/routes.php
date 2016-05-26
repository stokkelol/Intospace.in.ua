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
Route::get('/', 'PostController@index');

Route::get('/post/{slug}', [
    'as'    =>  'post',
    'uses'  =>  'PostController@post'
]);

Route::get('/tag/{slug}', [
    'as'    =>  'tag',
    'uses'  =>  'TagController@show'
]);

Route::get('/category/{slug}', [
    'as'    =>  'category',
    'uses'  =>  'CategoryController@show'
]);

Route::get('/home', 'HomeController@index');

Route::get('/feed', 'FeedController@feed');

/**
 * Routes for backend
 */
Route::group(['prefix' => 'backend', 'middleware' => 'auth'], function () {

    Route::get('/', [
        'as'    =>  'backend.index',
        'uses'  =>  'Backend\BackendController@index',
    ]);

    Route::resource('posts', 'Backend\PostController');

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

    Route::get('posts.set-category/{post_id}/{category_id}', [
        'as'    =>  'backend.post.to.category',
        'uses'  =>  'Backend\PostController@setCategory'
    ]);
});
