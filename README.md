# Liddle Forum

## A simple forum for your Laravel application

### Requirements

* Laravel 5.1.11+
* PHP 5.6+
* A Laravel project with a User model and database
* Optionally Laravel 5.3 if you wish to use notifications

### Installation

1. Use composer to add LiddleForum to your project

    ```
    composer require "liddledev/liddleforum"
    ```

2. Add the LiddleForum service provider to `config/app.php` providers:

    ```
    LiddleDev\LiddleForum\LiddleForumServiceProvider::class,
    ```

3. Run the following command to publish the LiddleForum assets:

    ```
    php artisan vendor:publish
    ```

4. Open up the LiddleForum config file located at

    ```
    app/config/liddleforum.php
    ```
    
    and edit the User model class to be your User model. By default it is `\App\User::class` which is what comes with Laravel.

5. Since new files have been copied to your project you will need to run:

    ```
    composer dump-autoload
    ```

6. LiddleForum needs to create some tables in your database in order to function. By default all tables will use the prefix `liddleforum_` but you can change this in the config if you wish. Once you have set your prefix, run:

    ```
    php artisan migrate
    ```

7. Inside the config you will see a `blade` array. You will need to fill in which layout file the pages should extend, what content section to use, and the names of two stacks which you must place in the head of your layout and just before the body closes. 
    For example, your layout file could look like this:
    ```
    <html>
    <head>
        @stack('head')
    </head>
    <body>
        <nav></nav>
        <div class="container">
            @yield('content')
        </div>
        @stack('footer')
    </body>
    </html>
    ```
    and your config would look like
    ```
    'blade' => [
        'layout' => 'layouts.app',
        'section' => 'content',
        'stacks' => [
            'head' => 'head',
            'footer' => 'footer',
        ]
    ],
    ```
    
8. In your database, add your personal user as an admin by adding yourself to the `liddleforum_admins` table.

9. Navigate to the admin panel at `domain.com/forums/admin` and add your categories. First add base categories - these cannot have threads and can only contain subcategories. Then add subcategories to these base categories to show on your home page. Alternatively, you can run the command `php artisan db:seed --class=LiddleForumExampleSeeder` to add some example categories for you.


The forum should now be viewable by going to *domain.com/forums* - however you can change the routes in the config if you wish

This is all of the necessary configuration required to get up and running. Follow the next section for further customisation and features

### Additional Features / Customisation

#### User Avatars

By default, user avatars are displayed using Gravatar. You can change the avatar driver in the config under `user.avatar.driver`

LiddleForum comes with `gravatar` and `user_column` but you are welcome to create your own by extending `\LiddleDev\LiddleForum\Drivers\Avatar\AvatarInterface` and adding it to the config

##### Gravatar

If you wish to use Gravatar, set the driver to `gravatar` and enter the email column of your user table in the gravatar options

##### User Column

Set the driver to `user_column` and set `url_column` to the column of your user table that contains the avatar URL

#### Text Editors

TinyMCE is used by default to create and reply to threads. You can change this in the config under the `text_editor` section.

You can choose between `tinymce`, `trumbowyg` or you can add your own by extending `\LiddleDev\LiddleForum\Drivers\TextEditor\TextEditorInterface`

If you choose to use Trumbowyg, note that it requires jQuery

#### Notifications

LiddleForum comes with the option to use the Laravel notification system that was introduced in version 5.3. Notifications are disabled by default.
If you are using at least 5.3 you can turn on notifications in the config by setting a notification type to enabled and extending the abstract class provided.

Note: Your user model needs to use the Notifiable trait

#### Moderators

Moderators can be added in the admin panel. Navigate to the moderators tab add moderators by entering the user ID of who you'd like to be a moderator.

You can either make them a global moderator or limit their moderation powers to a specific category and its children.

### Roadmap

Here are a list of features currently planned for future versions:

* Themes - provide a way to easily customise the CSS on the forum

### Final Notes

Please take a good look in `app/config/liddleforum.php` to make sure you customise the forum the way you want it. You'll find notes in there explaining more about each section.

If you have any issues using the forum please create an issue or pull request and I will look into it :)

