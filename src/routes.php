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

        Route::get('/', [
            'as' => 'all',
            'uses' => 'CategoriesController@getCategories',
        ]);

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
                    Route::post('edit', [
                        'as' => 'edit',
                        'uses' => 'PostsController@postEdit',
                    ]);

                    // Delete
                    Route::delete('/', [
                        'as' => 'delete',
                        'uses' => 'PostsController@deletePost',
                    ]);

                });
            });
        });
    });
});