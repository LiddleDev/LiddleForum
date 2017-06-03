<?php

return [

    /*
     * Configure this before running your migrations. This will prefix all tables created
     */
    'database_prefix' => 'liddleforum_',


    /*
     * Here you can customise everything to do with your users
     */
    'user' => [
        /*
         * Change this to your User model class name before running migrations
         */
        'model' => \App\User::class,

        /*
         * This is the property on your user model that will be used as the user's display name in the forums
         */
        'name_column' => 'name',

        /*
         * You can change where the avatars are pulled from here
         */
        'avatar' => [
            /*
             * If set to false, the default avatar URL will be used for all users
             */
            'enabled' => true,
            'default_url' => 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&f=y',

            /*
             * Please choose from one of the available drivers below or implement your own using AvatarInterface
             *
             * Gravatar is the default option which will use the user's email pulled from a column on your
             * user table. The column to be used can be changed in the options below
             *
             * User Column will pull the avatar URL from a column on your users table. Set which column
             * to pull from using the url_column option below. By default it uses $user->avatar_url
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


    /*
     * This is where you can change which templates and sections to use.
     *
     * layout: the file that all forum pages will extend
     * section: the section that the forum pages will use to put the content
     * stacks: we require you to add a stack in the head of you file and just before you close the body tag
     */
    'blade' => [
        'layout' => 'layouts.app',
        'section' => 'content',
        'stacks' => [
            'head' => 'head',
            'footer' => 'footer',
        ]
    ],


    /*
     * You can change the routes here. By default the base is set to domain.com/forums
     */
    'routes' => [
        'base' => 'forums',

        'threads' => 'threads',
        'categories' => 'categories',
        'replies' => 'replies',

        'admin' => 'admin',
    ],


    /*
     * Change the text to be shown above the forum here, or remove it from the view if it's not needed
     */
    'text' => [
        'heading' => 'LiddleForum',
        'subheading' => 'A simple forum for your Laravel application',
    ],


    /*
     * Apply any middleware to the forum routes
     */
    'middleware' => [
        'global' => ['web'],
        'home' => [],
        'categories' => [
            'view' => [],
        ],
        'threads' => [
            'create' => [],
            'view' => [],
            'edit' => [],
            'lock' => [],
            'unlock' => [],
            'sticky' => [],
            'unsticky' => [],
            'follow' => [],
            'unfollow' => [],
            'delete' => [],
        ],
        'posts' => [
            'create' => [],
            'edit' => [],
            'delete' => [],
        ],
        'admin' => [
            'admins' => [
                'index' => [],
                'create' => [],
                'delete' => [],
            ],
            'moderators' => [
                'index' => [],
                'create' => [],
                'delete' => [],
            ],
            'categories' => [
                'create' => [],
                'edit' => [],
                'delete' => [],
            ],
        ],
    ],


    /*
     * Choose how many items you would like to display per page
     */
    'paginate' => [
        'threads' => 15,
        'posts' => 10,
    ],


    /*
     * By default we use TinyMCE as the text editor to create threads and post replies.
     * You can choose between 'tinymce', 'trumbowyg' or implement your own.
     */
    'text_editor' => [
        /*
         * If set to false, a simple textarea will be used
         */
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
            // Update this to a class that extends \LiddleDev\LiddleForum\Notifications\AbstractFollowedThreadReceivedReply
            // This will not work until you extend the abstract class and enter it below
            'class' => \App\Notifications\FollowedThreadReceivedReply::class,
        ],

    ],

];
