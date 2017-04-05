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

    public function getDropdownName($withThreadCount = false)
    {
        $dropdownName = '';

        foreach ($this->getCategoryChain() as $parentCategory) {
            $dropdownName .= $parentCategory->name . ' > ';
        }

        $dropdownName .= $this->name;

        if ($withThreadCount) {
            $threadCount = $this->threads()->count();
            foreach ($this->getSubcategoriesRecursively() as $subcategory) {
                $threadCount += $subcategory->threads()->count();
            }

            $dropdownName .= ' (' . $threadCount . ' thread' . ($threadCount === 1 ? '' : 's') . ')';
        }

        return $dropdownName;
    }

    /**
     * @return Post
     */
    public function getMostRecentPost()
    {
        $categoryIds = [
            $this->getKey()
        ];

        $allSubcategories = $this->getSubcategoriesRecursively();
        foreach ($allSubcategories as $subcategory) {
            $categoryIds[] = $subcategory->getKey();
        }

        $thread = new Thread();
        $post = new Post();

        return Post::select($post->getTable() . '.*')
            ->join($thread->getTable(), $thread->getTable() . '.' . $thread->getKeyName(), '=', $post->getTable() . '.thread_id')
            ->whereIn($thread->getTable() . '.category_id', $categoryIds)
            ->orderBy($post->getTable() . '.created_at', 'DESC')->first();
    }

    /**
     * Get all of the subcategories of all of the children recursively
     * @return array
     */
    public function getSubcategoriesRecursively()
    {
        $allSubcategories = [];

        $subcategories = $this->subcategories;

        if ( ! count($subcategories)) {
            return [];
        }

        foreach ($subcategories as $category) {
            $allSubcategories = array_merge($allSubcategories, $category->getSubcategoriesRecursively());
            $allSubcategories[] = $category;
        }

        return $allSubcategories;
    }
}
