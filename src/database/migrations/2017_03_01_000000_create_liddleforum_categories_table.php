<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLiddleForumCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create(config('liddleforum.database_prefix') . 'categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('order')->default(1);

            $table
                ->foreign('parent_id')
                ->references('id')
                ->on(config('liddleforum.database_prefix') . 'categories')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::drop(config('liddleforum.database_prefix') . 'categories');
    }
}
