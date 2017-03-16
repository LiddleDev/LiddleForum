<?php

namespace LiddleDev\LiddleForum\Models;

use Illuminate\Database\Eloquent\Builder;

class Category extends LiddleForumModel
{
    protected $table = 'categories';

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'ASC');
        });
    }


    public function threads()
    {
        return $this->hasMany(Thread::class, 'category_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function posts()
    {
        return $this->hasManyThrough(Post::class, Thread::class, 'category_id', 'thread_id');
    }

    public function getCategoryChain()
    {
        $category = null;
        $categoryChain = [];

        while($category = $category ? $category->parent : $this->parent) {
            $categoryChain[] = $category;
        }

        return array_reverse($categoryChain);
    }

    /**
     * @return Post
     */
    public function getMostRecentPost()
    {
        return $this->posts()->orderBy('created_at', 'DESC')->first();
    }
}
