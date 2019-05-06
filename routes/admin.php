<?php
Route::get('/', function () {
    return redirect('/login');
});
Route::get('/login', 'Admin\Auth\LoginController@showLoginForm');
Route::post('/login', 'Admin\Auth\LoginController@login');
Route::post('/logout', 'Admin\Auth\LoginController@logout');
if (env('APP_DEBUG')) {
    Route::get('/logout', 'Admin\Auth\LoginController@logout');
}

Route::middleware('auth')->group(function () {
    /* api datatable */
    Route::get('/setting/menus/data', 'Admin\Setting\MenuController@datatable')->name('menus.data');
    Route::get('/setting/menu-groups/data', 'Admin\Setting\MenuGroupController@datatable')->name('menu-groups.data');
    Route::get('/setting/roles/data', 'Admin\Setting\RoleController@datatable')->name('roles.data');
    Route::get('/data/users/data', 'Admin\Data\UserController@datatable')->name('users.data');
    Route::get('/data/categories/data', 'Admin\Data\CategoryController@datatable')->name('categories.data');
    Route::get('/data/tags/data', 'Admin\Data\TagController@datatable')->name('tags.data');
    Route::get('/content/pages/data', 'Admin\Content\PageController@datatable')->name('pages.data');
    Route::get('/content/posts/data', 'Admin\Content\PostController@datatable')->name('posts.data');
    // Route::get('/content/banners/data', 'Admin\Content\BannerController@datatable')->name('banners.data');
    Route::get('/report/inbox/data', 'Admin\Report\InboxController@datatable')->name('inbox.data');
    Route::get('/report/comments/data', 'Admin\Report\CommentController@datatable')->name('comments.data');
    Route::get('/report/incoming-terms/data', 'Admin\Report\IntermController@datatable')->name('interms.data');
    Route::get('/report/subscribers/data', 'Admin\Report\SubscriberController@datatable')->name('subscribers.data');
    Route::get('/log/activities/data', 'Admin\Log\ActivityController@datatable')->name('activities.data');
    Route::get('/log/errors/data', 'Admin\Log\ErrorController@datatable')->name('errors.data');
    Route::get('/log/visitors/data', 'Admin\Log\VisitorController@datatable')->name('visitors.data');

    /* api ajax */
    Route::get('/ajax/pageview', 'Admin\AjaxController@pageview')->name('ajax.pageview');
    Route::get('/ajax/popularpost', 'Admin\AjaxController@popularpost')->name('ajax.popularpost');
    Route::get('/ajax/recentcomment', 'Admin\AjaxController@recentcomment')->name('ajax.recentcomment');
    Route::get('/ajax/term/{term}', 'Admin\AjaxController@term')->name('ajax.term');

    /* sort menu */
    // Route::get('/setting/menus/sort', 'Admin\Setting\MenuController@sort')->name('menus.sort');
    // Route::put('/setting/menus/sort', 'Admin\Setting\MenuController@sortSave')->name('menus.sortSave');

    /* sort banner */
    /* Route::get('/content/banners/sort', 'Admin\Content\BannerController@sort')->name('banners.sort')->name('banners.sort');
    Route::put('/content/banners/sort', 'Admin\Content\BannerController@sortSave')->name('banners.sortSave'); */

    Route::middleware('access')->group(function () {
        /* dashboard */
        Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard.index');

        /* module setting routes */
        Route::prefix('setting')->group(function () {
            Route::resources([
                '/application' => 'Admin\Setting\ApplicationController',
                '/menus' => 'Admin\Setting\MenuController',
                '/menu-groups' => 'Admin\Setting\MenuGroupController',
                '/roles' => 'Admin\Setting\RoleController',
            ], [
                'parameters' => [
                    'menu-groups' => 'menugroup',
                ],
            ]);
        });

        /* module data routes */
        Route::prefix('data')->group(function () {
            Route::resources([
                '/users' => 'Admin\Data\UserController',
                '/categories' => 'Admin\Data\CategoryController',
                '/tags' => 'Admin\Data\TagController',
            ]);
        });

        /* module content routes */
        Route::prefix('content')->group(function () {
            Route::resources([
                '/pages' => 'Admin\Content\PageController',
                '/posts' => 'Admin\Content\PostController',
                // '/banners' => 'Admin\Content\BannerController',
                // '/gallery/photos' => 'Admin\Content\Gallery\PhotoController',
                // '/gallery/videos' => 'Admin\Content\Gallery\VideoController',
                // '/products' => 'Admin\Content\Product\ProductController',
            ]);
            // Route::resource('/products/categories', 'Admin\Content\Product\CategoryController')->names('products.categories');
            // Route::resource('/products/tags', 'Admin\Content\Product\TagController')->names('products.tags');
        });

        /* module report routes */
        Route::prefix('report')->group(function () {
            Route::resources([
                '/inbox' => 'Admin\Report\InboxController',
                '/comments' => 'Admin\Report\CommentController',
                '/incoming-terms' => 'Admin\Report\IntermController',
                '/subscribers' => 'Admin\Report\SubscriberController',
            ]);
        });

        /* module log routes */
        Route::prefix('log')->group(function () {
            Route::resources([
                '/activities' => 'Admin\Log\ActivityController',
                '/errors' => 'Admin\Log\ErrorController',
                '/visitors' => 'Admin\Log\VisitorController',
            ]);
        });

    });
});
