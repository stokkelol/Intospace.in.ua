<?php
declare(strict_types=1);

Route::auth();

/**
 * Routes for frontend
 */
Route::get('/', 'MainController@index');

Route::get('/posts/{slug}', [
    'as' => 'posts',
    'uses' => 'PostController@show'
]);

Route::get('/posts', 'PostController@index');

Route::get('/videos', 'VideoController@index');

Route::get('/newsfeed', 'NewsfeedController@index');

Route::get('/blog', 'BlogController@index');

Route::get('/shortreviews', 'ShortReviewController@index');

Route::get('/monthlyreviews', 'MonthlyReviewController@index');

Route::get('/monthlyreviews/{slug}', [
    'as' => 'monthlyreviews',
    'uses' => 'MonthlyReviewController@show'
]);

Route::get('/search', 'SearchController@index');

Route::get('/videos/{slug}', [
    'as' => 'videos',
    'uses' => 'VideoController@video'
]);

Route::get('/tags/{slug}', [
    'as' => 'tags',
    'uses' => 'TagController@show'
]);

Route::get('/categories/{slug}', [
    'as' => 'categories',
    'uses' => 'CategoryController@show'
]);

Route::get('/home', 'HomeController@index');

Route::get('/feed', 'FeedController@feed');

Route::get('/sitemap', 'SitemapController@sitemap');

Route::get('/bands', 'BandController@index');

Route::get('/bands/{slug}', [
    'as' => 'bands',
    'uses' => 'BandController@show'
]);

Route::get('/profile', 'UserController@show');

Route::group(['prefix' => 'telegram/' . config('telegram.bot_token')], function () {
    Route::get('/init', ['uses' => 'TelegramController@init']);
    Route::post('/webhook', ['uses' => 'TelegramController@processWebhook']);
    Route::get('/set-webhook', ['uses' => 'TelegramController@setWebhook']);
    Route::get('/info', ['uses' => 'TelegramController@info']);
});

/**
 * Routes for backend
 */

Route::group(['prefix' => 'backend', 'middleware' => ['role:admin|owner|demo'], 'namespace' => 'Backend'], function () {

    Route::get('/', [
        'as' => 'backend.index',
        'uses' => 'BackendController@index',
    ]);

    Route::get('/posts/updateall', [
        'as' => 'backend.posts.updateall',
        'uses' => 'PostController@getAllUpdated'
    ]);

    Route::get('/posts', [
        'as' => 'backend.posts.index',
        'uses' => 'PostController@index'
    ]);

    Route::get('/posts/create', [
        'as' => 'backend.posts.create',
        'uses' => 'PostController@create'
    ]);

    Route::post('/posts', [
        'as' => "backend.posts.store",
        'uses' => "PostController@store"
    ]);

    Route::get('/posts/{post_id}', [
       'as' => 'backend.posts.edit',
       'uses' => 'PostController@edit'
    ]);

    Route::patch('/posts/{post_id}', [
       'as' => 'backend.posts.update',
       'uses' => 'PostController@update'
    ]);

    Route::delete('/posts/{post_id}', [
       'as' => 'backend.posts.delete',
       'uses' => 'PostController@destroy'
    ]);

    Route::get('/posts/preview{post_id}', [
        'as' => 'backend.posts.post-preview',
        'uses' => 'PostController@postPreviewOnAjaxRequest'
    ]);

    Route::get('/posts/to-draft/{post_id}', [
        'as' => 'backend.posts.to-draft',
        'uses' => 'PostController@toDraft'
    ]);

    Route::get('/posts/to-active/{post_id}', [
        'as' => 'backend.posts.to-active',
        'uses' => 'PostController@toActive'
    ]);

    Route::get('/posts/to-deleted/{post_id}', [
        'as' => 'backend.posts.to-deleted',
        'uses' => 'PostController@toDeleted'
    ]);

    Route::get('/posts/to-pinned/{post_id}', [
        'as' => 'backend.posts.to-pinned',
        'uses' => 'PostController@toPinned'
    ]);

    Route::get('/posts/to-regular/{post_id}', [
        'as' => 'backend.posts.to-regular',
        'uses' => 'PostController@toRegular'
    ]);


    Route::get('/posts/search/', [
        'as' => 'backend.posts.search',
        'uses' => 'PostController@index'
    ]);

    Route::resource('categories', 'CategoryController');

//    Route::resource('tags', 'Backend\TagController');
    Route::get('/tags', ['as' => 'backend.tags.index', 'uses' => 'TagController@index']);
    Route::post('/tags/create', ['as' => 'backend.tags.create', 'uses' => 'TagController@create']);
    Route::get('/tags/{model}', ['as' => 'backend.tags.show', 'uses' => 'TagController@show']);
    Route::get('/tags/{model}/edit', ['as' => 'backend.tags.edit', 'uses' => 'TagController@edit']);

    Route::get('/users', [
        'as' => 'backend.users.index',
        'uses' => 'UserController@index'
    ]);
    Route::get('/users/create', [
       'as' => 'backend.users.create',
       'uses' => 'UserController@create'
    ]);
    Route::post('/users', [
        'as' => 'backend.users.store',
        'uses' => 'UserController@store'
    ]);
    Route::get('/users/{user_id}', [
       'as' => 'backend.users.edit',
       'uses' => 'UserController@edit'
    ]);
    Route::patch('/users/{user_id}', [
       'as' => 'backend.users.update',
       'user' => 'UserController@update'
    ]);

    Route::get('/videos', [
        'as' => 'backend.videos.index',
        'uses' => 'VideoController@index'
    ]);
    Route::get('/videos/create', [
       'as' => 'backend.videos.create',
       'uses' => 'VideoController@create'
    ]);
    Route::post('/videos', [
        'as' => 'backend.videos.store',
        'uses' => 'VideoController@store'
    ]);
    Route::get('/videos/{video_id}', [
        'as' => 'backend.videos.edit',
        'uses' => 'VideoController@edit'
    ]);
    Route::patch('/videos/{video_id}', [
        'as' => 'backend.videos.update',
        'user' => 'VideoController@update'
    ]);

    Route::get('/bands', [
        'as' => 'backend.bands.index',
        'uses' => 'BandController@index'
    ]);
    Route::get('/bands/create', [
        'as' => 'backend.bands.create',
        'uses' => 'BandController@create'
    ]);
    Route::post('/bands', [
        'as' => 'backend.bands.store',
        'uses' => 'BandController@store'
    ]);
    Route::get('/bands/{band_id}', [
        'as' => 'backend.bands.edit',
        'uses' => 'BandController@edit'
    ]);
    Route::patch('/bands/{band_id}', [
        'as' => 'backend.bands.update',
        'user' => 'BandController@update'
    ]);

    Route::get('/blogs', [
        'as' => 'backend.blogs.index',
        'uses' => 'BlogController@index'
    ]);
    Route::get('/blogs/create', [
        'as' => 'backend.blogs.create',
        'uses' => 'BlogController@create'
    ]);
    Route::post('/blogs', [
        'as' => 'backend.blogs.store',
        'uses' => 'BlogController@store'
    ]);
    Route::get('/blogs/{blog_id}', [
        'as' => 'backend.blogs.edit',
        'uses' => 'BlogController@edit'
    ]);
    Route::patch('/blogs/{blog_id}', [
        'as' => 'backend.blogs.update',
        'user' => 'BlogController@update'
    ]);

    Route::get('/monthlyreviews', [
        'as' => 'backend.monthlyreviews.index',
        'uses' => 'MonthlyReviewController@index'
    ]);
    Route::get('/monthlyreviews/create', [
        'as' => 'backend.monthlyreviews.create',
        'uses' => 'MonthlyReviewController@create'
    ]);
    Route::post('/monthlyreviews', [
        'as' => 'backend.monthlyreviews.store',
        'uses' => 'MonthlyReviewController@store'
    ]);
    Route::get('/monthlyreviews/{monthlyreview_id}', [
        'as' => 'backend.monthlyreviews.edit',
        'uses' => 'MonthlyReviewController@edit'
    ]);
    Route::patch('/monthlyreviews/{monthlyreview_id}', [
        'as' => 'backend.monthlyreviews.update',
        'user' => 'MonthlyReviewController@update'
    ]);

    Route::get('files', 'FileController@index');

    Route::get('files/image/', [
        'as' => 'backend.files.open-image',
        'uses' => 'FileController@openImage'
    ]);

    Route::post('files/image/store', [
        'as' => 'backend.files.store',
        'uses' => 'FileController@store'
    ]);

    Route::get('/monthlyreviews/to-draft/{post_id}', [
        'as' => 'backend.monthlyreviews.to-draft',
        'uses' => 'MonthlyReviewController@toDraft'
    ]);

    Route::get('/monthlyreviews/to-active/{post_id}', [
        'as' => 'backend.monthlyreviews.to-active',
        'uses' => 'MonthlyReviewController@toActive'
    ]);

    Route::get('posts.set-category/{post_id}/{category_id}', [
        'as' => 'backend.post.to.category',
        'uses' => 'PostController@setCategory'
    ]);
});

Route::get('pages/{page_title}', 'PageController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
