<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLiddleForumModeratorsTable extends Migration
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    private $user;

    public function __construct()
    {
        $userClass = config('liddleforum.user.model');
        $user = new $userClass;

        if ( ! $user instanceof \Illuminate\Database\Eloquent\Model) {
            throw new Exception('Please set your User model in your liddleforum.php config');
        }

        $this->user = $user;
    }

    public function up()
    {
        Schema::create(config('liddleforum.database_prefix') . 'moderators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->unsigned()->nullable();

            $table->unique(['user_id', 'category_id']);

            $table
                ->foreign('user_id')
                ->references($this->user->getKeyName())
                ->on($this->user->getTable())
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table
                ->foreign('category_id')
                ->references('id')
                ->on(config('liddleforum.database_prefix') . 'categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::drop(config('liddleforum.database_prefix') . 'moderators');
    }
}
