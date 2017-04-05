<?php

$configHelper = function ($key) {
    return $this->app->config->get('liddleforum.' . $key);
};

// Base routes
Route::group([
    'as' => 'liddleforum.',
    'prefix' => $configHelper('routes.base'),
    'namespace' => 'LiddleDev\LiddleForum\Controllers',
    'middleware' => $configHelper('middleware.global'),
], function () use ($configHelper) {

    Route::get('/', [
        'as' => 'index',
        'uses' => 'LiddleForumController@getIndex',
    ]);

    // Category routes
    Route::group([
        'as' => 'categories.',
        'prefix' => $configHelper('routes.categories'),
    ], function () {

        Route::get('{category}', [
            'as' => 'view',
            'uses' => 'CategoriesController@getCategory',
        ]);

    });

    // Thread routes.
    Route::group([
        'as' => 'threads.',
        'prefix' => $configHelper('routes.threads'),
    ], function () use ($configHelper) {

        // Create
        Route::get('create', [
            'as' => 'create',
            'uses' => 'ThreadsController@getCreate',
        ]);

        Route::post('create', [
            'as' => 'create',
            'uses' => 'ThreadsController@postCreate',
        ]);

        // Individual
        Route::group([
            'prefix' => '{thread_slug}',
        ], function () use ($configHelper) {

            // View
            Route::get('/', [
                'as' => 'view',
                'uses' => 'ThreadsController@getThread',
            ]);

            // Edit
            Route::get('edit', [
                'as' => 'edit',
                'uses' => 'ThreadsController@getEdit',
            ]);

            Route::post('edit', [
                'as' => 'edit',
                'uses' => 'ThreadsController@postEdit',
            ]);

            // Lock
            Route::post('lock', [
                'as' => 'lock',
                'uses' => 'ThreadsController@postLock',
            ]);

            // Unlock
            Route::post('unlock', [
                'as' => 'unlock',
                'uses' => 'ThreadsController@postUnlock',
            ]);

            // Sticky
            Route::post('sticky', [
                'as' => 'sticky',
                'uses' => 'ThreadsController@postSticky',
            ]);

            // Unsticky
            Route::post('unsticky', [
                'as' => 'unsticky',
                'uses' => 'ThreadsController@postUnsticky',
            ]);

            // Follow
            Route::post('follow', [
                'as' => 'follow',
                'uses' => 'ThreadsController@postFollow',
            ]);

            // Unfollow
            Route::post('unfollow', [
                'as' => 'unfollow',
                'uses' => 'ThreadsController@postUnfollow',
            ]);

            // Delete
            Route::delete('/', [
                'as' => 'delete',
                'uses' => 'ThreadsController@deleteThread',
            ]);

            // Posts
            Route::group([
                'as' => 'posts.',
                'prefix' => $configHelper('routes.posts'),
            ], function () {

                // Create
                Route::post('create', [
                    'as' => 'create',
                    'uses' => 'PostsController@postCreate',
                ]);

                // Individual
                Route::group([
                    'prefix' => '{post_id}',
                ], function () {

                    // Edit
                    Route::get('edit', [
                        'as' => 'edit',
                        'uses' => 'PostsController@getEdit',
                    ]);

                    // Edit
                    Route::post('edit', [
                        'as' => 'edit',
                        'uses' => 'PostsController@postEdit',
                    ]);

                    // Delete
                    Route::delete('delete', [
                        'as' => 'delete',
                        'uses' => 'PostsController@deletePost',
                    ]);

                });
            });
        });
    });

    // Thread routes.
    Route::group([
        'as' => 'admin.',
        'prefix' => $configHelper('routes.admin'),
        'namespace' => 'Admin',
    ], function () use ($configHelper) {

        // Index
        Route::get('/', [
            'as' => 'index',
            'uses' => 'HomeController@getIndex',
        ]);

        // Admins
        Route::group([
            'as' => 'admins.',
            'prefix' => 'admins',
        ], function() {

            // Index
            Route::get('/', [
                'as' => 'index',
                'uses' => 'AdminsController@getIndex',
            ]);

            // Create
            Route::post('create', [
                'as' => 'create',
                'uses' => 'AdminsController@postCreate',
            ]);

            // Individual
            Route::group([
                'prefix' => '{admin_id}',
            ], function() {

                // Delete
                Route::delete('delete', [
                    'as' => 'delete',
                    'uses' => 'AdminsController@deleteAdmin',
                ]);

            });

        });

        // Moderators
        Route::group([
            'as' => 'moderators.',
            'prefix' => 'moderators',
        ], function() {

            // Index
            Route::get('/', [
                'as' => 'index',
                'uses' => 'ModeratorsController@getIndex',
            ]);

            // Create
            Route::post('create', [
                'as' => 'create',
                'uses' => 'ModeratorsController@postCreate',
            ]);

            // Individual
            Route::group([
                'prefix' => '{moderator_id}',
            ], function() {

                // Delete
                Route::delete('delete', [
                    'as' => 'delete',
                    'uses' => 'ModeratorsController@deleteModerator',
                ]);

            });

        });

        // Categories
        Route::group([
            'as' => 'categories.',
            'prefix' => 'categories',
        ], function() {

            // Create
            Route::get('create', [
                'as' => 'create',
                'uses' => 'CategoriesController@getCreate',
            ]);

            Route::post('create', [
                'as' => 'create',
                'uses' => 'CategoriesController@postCreate',
            ]);

            // Edit
            Route::get('edit', [
                'as' => 'edit',
                'uses' => 'CategoriesController@getEdit',
            ]);

            Route::post('edit', [
                'as' => 'edit',
                'uses' => 'CategoriesController@postEdit',
            ]);

            // Delete
            Route::get('delete', [
                'as' => 'delete',
                'uses' => 'CategoriesController@getDelete',
            ]);

            Route::delete('delete', [
                'as' => 'delete',
                'uses' => 'CategoriesController@deleteCategory',
            ]);

        });

    });
});