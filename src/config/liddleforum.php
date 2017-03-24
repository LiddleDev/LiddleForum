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
             * Please choose from one of the available drivers below or implement your own using AvatarInterface
             */
            'driver' => 'gravatar',

            'drivers' => [
                'gravatar' => [
                    'class' => \LiddleDev\LiddleForum\Drivers\Avatar\Gravatar::class,
                    'email_column' => 'email',
                    'default' => 'mm',
                ],

                'user_column' => [
                    'class' => \LiddleDev\LiddleForum\Drivers\Avatar\UserColumn::class,
                    'url_column' => 'avatar_url',
                ],
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
        'enabled' => true,

        /*
         * Please choose from one of the available drivers below or implement your own using TextEditorInterface
         */
        'driver' => 'tinymce',

        'drivers' => [
            'tinymce' => [
                'class' => \LiddleDev\LiddleForum\Drivers\TextEditor\TinyMCE::class,

                // https://www.tinymce.com/docs/configure/editor-appearance/
                'config' => [
                    'plugins' => '"link image"',
                    'toolbar' => '"bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link image"',
                    'menubar' => 'false',
                    'height' => '200',
                ]
            ],

            'trumbowyg' => [
                'class' => \LiddleDev\LiddleForum\Drivers\TextEditor\Trumbowyg::class,

                // https://alex-d.github.io/Trumbowyg/documentation.html
                'config' => [
                    'autogrow' => 'true',
                ],
            ],
        ],

    ],

    /*
     * Requires Laravel 5.3 and your User model to use the Illuminate\Notifications\Notifiable trait
     * You MUST update each class you wish to use to a class of your own that extends the abstract class given
     *
     * Find more information about Laravel notifications here: https://laravel.com/docs/5.3/notifications
     */
    'notifications' => [

        'followed_thread_received_reply' => [
            'enabled' => false,
            // Update this to a class name that extends \LiddleDev\LiddleForum\Notifications\AbstractFollowedThreadReceivedReply
            'class' => \App\Notifications\FollowedThreadReceivedReply::class,
        ],

    ],

];
