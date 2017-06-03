<?php

$configHelper = function ($key, $default = null) {
    return $this->app->config->get('liddleforum.' . $key, $default);
};

// Base routes
Route::group([
    'as' => 'liddleforum.',
    'prefix' => $configHelper('routes.base'),
    'namespace' => 'LiddleDev\LiddleForum\Controllers',
    'middleware' => $configHelper('middleware.global', []),
], function () use ($configHelper) {

    Route::get('/', [
        'as' => 'index',
        'uses' => 'LiddleForumController@getIndex',
        'middleware' => $configHelper('middleware.home', []),
    ]);

    // Category routes
    Route::group([
        'as' => 'categories.',
        'prefix' => $configHelper('routes.categories'),
    ], function () use ($configHelper) {

        Route::get('{category}', [
            'as' => 'view',
            'uses' => 'CategoriesController@getCategory',
            'middleware' => $configHelper('middleware.categories.view', []),
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
            'middleware' => $configHelper('middleware.threads.create', []),
        ]);

        Route::post('create', [
            'as' => 'create',
            'uses' => 'ThreadsController@postCreate',
            'middleware' => $configHelper('middleware.threads.create', []),
        ]);

        // Individual
        Route::group([
            'prefix' => '{thread_slug}',
        ], function () use ($configHelper) {

            // View
            Route::get('/', [
                'as' => 'view',
                'uses' => 'ThreadsController@getThread',
                'middleware' => $configHelper('middleware.threads.view', []),
            ]);

            // Edit
            Route::get('edit', [
                'as' => 'edit',
                'uses' => 'ThreadsController@getEdit',
                'middleware' => $configHelper('middleware.threads.edit', []),
            ]);

            Route::post('edit', [
                'as' => 'edit',
                'uses' => 'ThreadsController@postEdit',
                'middleware' => $configHelper('middleware.threads.edit', []),
            ]);

            // Lock
            Route::post('lock', [
                'as' => 'lock',
                'uses' => 'ThreadsController@postLock',
                'middleware' => $configHelper('middleware.threads.lock', []),
            ]);

            // Unlock
            Route::post('unlock', [
                'as' => 'unlock',
                'uses' => 'ThreadsController@postUnlock',
                'middleware' => $configHelper('middleware.threads.unlock', []),
            ]);

            // Sticky
            Route::post('sticky', [
                'as' => 'sticky',
                'uses' => 'ThreadsController@postSticky',
                'middleware' => $configHelper('middleware.threads.sticky', []),
            ]);

            // Unsticky
            Route::post('unsticky', [
                'as' => 'unsticky',
                'uses' => 'ThreadsController@postUnsticky',
                'middleware' => $configHelper('middleware.threads.unsticky', []),
            ]);

            // Follow
            Route::post('follow', [
                'as' => 'follow',
                'uses' => 'ThreadsController@postFollow',
                'middleware' => $configHelper('middleware.threads.follow', []),
            ]);

            // Unfollow
            Route::post('unfollow', [
                'as' => 'unfollow',
                'uses' => 'ThreadsController@postUnfollow',
                'middleware' => $configHelper('middleware.threads.unfollow', []),
            ]);

            // Delete
            Route::delete('/', [
                'as' => 'delete',
                'uses' => 'ThreadsController@deleteThread',
                'middleware' => $configHelper('middleware.threads.delete', []),
            ]);

            // Posts
            Route::group([
                'as' => 'posts.',
                'prefix' => $configHelper('routes.posts'),
            ], function () use ($configHelper) {

                // Create
                Route::post('create', [
                    'as' => 'create',
                    'uses' => 'PostsController@postCreate',
                    'middleware' => $configHelper('middleware.posts.create', []),
                ]);

                // Individual
                Route::group([
                    'prefix' => '{post_id}',
                ], function () use ($configHelper) {

                    // Edit
                    Route::get('edit', [
                        'as' => 'edit',
                        'uses' => 'PostsController@getEdit',
                        'middleware' => $configHelper('middleware.posts.edit', []),
                    ]);

                    // Edit
                    Route::post('edit', [
                        'as' => 'edit',
                        'uses' => 'PostsController@postEdit',
                        'middleware' => $configHelper('middleware.posts.edit', []),
                    ]);

                    // Delete
                    Route::delete('delete', [
                        'as' => 'delete',
                        'uses' => 'PostsController@deletePost',
                        'middleware' => $configHelper('middleware.posts.delete', []),
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
        ], function() use ($configHelper) {

            // Index
            Route::get('/', [
                'as' => 'index',
                'uses' => 'AdminsController@getIndex',
                'middleware' => $configHelper('middleware.admin.admins.index', []),
            ]);

            // Create
            Route::post('create', [
                'as' => 'create',
                'uses' => 'AdminsController@postCreate',
                'middleware' => $configHelper('middleware.admin.admins.create', []),
            ]);

            // Individual
            Route::group([
                'prefix' => '{admin_id}',
            ], function() use ($configHelper) {

                // Delete
                Route::delete('delete', [
                    'as' => 'delete',
                    'uses' => 'AdminsController@deleteAdmin',
                    'middleware' => $configHelper('middleware.admin.admins.delete', []),
                ]);

            });

        });

        // Moderators
        Route::group([
            'as' => 'moderators.',
            'prefix' => 'moderators',
        ], function() use ($configHelper) {

            // Index
            Route::get('/', [
                'as' => 'index',
                'uses' => 'ModeratorsController@getIndex',
                'middleware' => $configHelper('middleware.admin.moderators.index', []),
            ]);

            // Create
            Route::post('create', [
                'as' => 'create',
                'uses' => 'ModeratorsController@postCreate',
                'middleware' => $configHelper('middleware.admin.moderators.create', []),
            ]);

            // Individual
            Route::group([
                'prefix' => '{moderator_id}',
            ], function() use ($configHelper) {

                // Delete
                Route::delete('delete', [
                    'as' => 'delete',
                    'uses' => 'ModeratorsController@deleteModerator',
                    'middleware' => $configHelper('middleware.admin.moderators.delete', []),
                ]);

            });

        });

        // Categories
        Route::group([
            'as' => 'categories.',
            'prefix' => 'categories',
        ], function() use ($configHelper) {

            // Create
            Route::get('create', [
                'as' => 'create',
                'uses' => 'CategoriesController@getCreate',
                'middleware' => $configHelper('middleware.admin.categories.create', []),
            ]);

            Route::post('create', [
                'as' => 'create',
                'uses' => 'CategoriesController@postCreate',
                'middleware' => $configHelper('middleware.admin.categories.create', []),
            ]);

            // Edit
            Route::get('edit', [
                'as' => 'edit',
                'uses' => 'CategoriesController@getEdit',
                'middleware' => $configHelper('middleware.admin.categories.edit', []),
            ]);

            Route::post('edit', [
                'as' => 'edit',
                'uses' => 'CategoriesController@postEdit',
                'middleware' => $configHelper('middleware.admin.categories.edit', []),
            ]);

            // Delete
            Route::get('delete', [
                'as' => 'delete',
                'uses' => 'CategoriesController@getDelete',
                'middleware' => $configHelper('middleware.admin.categories.delete', []),
            ]);

            Route::delete('delete', [
                'as' => 'delete',
                'uses' => 'CategoriesController@deleteCategory',
                'middleware' => $configHelper('middleware.admin.categories.delete', []),
            ]);

        });

    });
});