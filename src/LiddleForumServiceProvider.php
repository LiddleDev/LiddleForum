<?php

namespace LiddleDev\LiddleForum;

use Illuminate\Support\ServiceProvider;

class LiddleForumServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/assets' => public_path('vendor/liddledev/liddleforum/assets'),
        ], 'assets');

        $this->publishes([
            __DIR__.'/config/liddleforum.php' => config_path('liddleforum.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/database/migrations/' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/database/seeds/' => database_path('seeds'),
        ], 'seeds');

        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->loadViewsFrom(resource_path('views/vendor/liddleforum'), 'liddleforum');

        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/liddleforum'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\LiddleDev\LiddleForum\Helpers\ThreadHelper::class, function ($app) {
            return new \LiddleDev\LiddleForum\Helpers\ThreadHelper();
        });

        $this->app->bind(\LiddleDev\LiddleForum\Drivers\Avatar\AvatarInterface::class, function ($app) {
            if ( ! config('liddleforum.user.avatar.enabled', false)) {
                return new \LiddleDev\LiddleForum\Drivers\Avatar\Disabled();
            }

            $driver = config('liddleforum.user.avatar.driver');
            $className = config('liddleforum.user.avatar.drivers.' . $driver . '.class');

            return new $className;
        });

        $this->app->bind(\LiddleDev\LiddleForum\Drivers\TextEditor\TextEditorInterface::class, function ($app) {
            if ( ! config('liddleforum.text_editor.enabled', false)) {
                return new \LiddleDev\LiddleForum\Drivers\TextEditor\Disabled();
            }

            $driver = config('liddleforum.text_editor.driver');
            $className = config('liddleforum.text_editor.drivers.' . $driver . '.class');

            return new $className;
        });

        $this->app->bind(\HTMLPurifier::class, function ($app) {
            // TODO pull config from liddleforum config
            $config = \HTMLPurifier_Config::createDefault();
            return new \HTMLPurifier($config);
        });
    }
}
