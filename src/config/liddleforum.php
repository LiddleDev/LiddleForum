<?php

return [

    'database_prefix' => 'liddleforum_',


    'user' => [
        'model' => \App\User::class,
        'name_column' => 'name',
        'profile_url' => 'user/{id}',

        'avatar' => [
            'enabled' => true,
            'default_url' => 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&f=y',

            /*
             * Default avatar drivers provided with this package are listed below. If you'd like to
             * create your own, please implement \LiddleDev\LiddleForum\Drivers\Avatar\AvatarInterface::class
             *
             * Gravatar: \LiddleDev\LiddleForum\Drivers\Avatar\Gravatar::class
             * Use an email column from your user table to pull their Gravatar
             *
             * UserColumn: \LiddleDev\LiddleForum\Drivers\Avatar\UserColumn::class
             * Use a direct URL from your user table
             */
            'driver' => \LiddleDev\LiddleForum\Drivers\Avatar\Gravatar::class,

            'gravatar' => [
                'email_column' => 'email',
                'default' => 'mm',
            ],
            'user_column' => [
                'url_column' => 'avatar_url',
            ],
        ],
    ],


    'blade' => [
        'layout' => 'layouts.app',
        'section' => 'content',
        'stacks' => [
            'head' => 'head',
            'footer' => 'footer',
        ]
    ],


    'routes' => [
        'base' => 'forums',

        'threads' => 'threads',
        'categories' => 'categories',
        'replies' => 'replies',
    ],


    'text' => [
        'heading' => 'LiddleForum',
        'subheading' => 'A simple forum for your Laravel application',
    ],


    'middleware' => [
        'global' => ['web'],
    ],


    'paginate' => [
        'per_page' => 10,
    ],


    'text_editor' => [
        'driver' => 'tinymce',

        'tinymce' => [
            'plugins' => 'link image',
            'toolbar' => 'bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
        ],
    ],

];
