<?php

namespace LiddleDev\LiddleForum\Models;

use Illuminate\Database\Eloquent\Builder;

class Category extends LiddleForumModel
{
    protected $table = 'categories';

    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'order', 'parent_id'];

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

        /** @var Category[] $subcategories */
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

    /**
     * Get the total count of all threads and posts including all children
     * @return array
     */
    public function getRecursiveThreadAndPostCount()
    {
        $threadCount = $this->threads()->count();
        $postCount = $this->posts()->count();

        /** @var Category[] $subcategories */
        $subcategories = $this->getSubcategoriesRecursively();
        foreach ($subcategories as $subcategory) {
            $threadCount += $subcategory->threads()->count();
            $postCount += $subcategory->posts()->count();
        }

        return [
            'threads' => $threadCount,
            'posts' => $postCount,
        ];
    }

    /**
     * Get all categories that can be used as parent category without creating circular parent chains
     * @return Category[]
     */
    public function getPossibleParentCategories()
    {
        // TODO make more efficient. fine for now as it's only used in admin panel

        $idsToExclude = [$this->id];

        $subcategories = $this->getSubcategoriesRecursively();
        foreach ($subcategories as $subcategory) {
            $idsToExclude[] = $subcategory->id;
        }

        return Category::whereNotIn('id', $idsToExclude)->orderBy('parent_id')->get();

    }
}
