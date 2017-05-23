<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLiddleForumThreadsTable extends Migration
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    private $user;

    public function __construct()
    {
        $userClass = config('liddleforum.user.model');

        if ( ! class_exists($userClass)) {
            throw new RuntimeException(sprintf('Class "%s" does not exist', $userClass));
        }

        $user = new $userClass();

        if ( ! $user instanceof \Illuminate\Database\Eloquent\Model) {
            throw new RuntimeException('Please set your User model in your liddleforum.php config');
        }

        $this->user = $user;
    }

    public function up()
    {
        Schema::create(config('liddleforum.database_prefix') . 'threads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('title');
            $table->string('slug')->unique();
            $table->integer('user_id')->unsigned()->nullable();
            $table->boolean('locked')->default(0);
            $table->boolean('stickied')->default(0);
            $table->integer('views')->unsigned()->default(0);
            $table->boolean('has_replies')->default(0);
            $table->timestamps();

            $table
                ->foreign('category_id')
                ->references('id')
                ->on(config('liddleforum.database_prefix') . 'categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table
                ->foreign('user_id')
                ->references($this->user->getKeyName())
                ->on($this->user->getTable())
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::drop(config('liddleforum.database_prefix') . 'threads');
    }
}
