<?php

use Illuminate\Database\Seeder;
use LiddleDev\LiddleForum\Models\Category;

class LiddleForumExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addCategories();
        $this->addThreads();
    }

    protected function addCategories()
    {
        $categories = [
            [
                'slug' => 'general',
                'name' => 'General',
                'order' => 1,
            ],
            [
                'parent_id' => 1,
                'slug' => 'announcements',
                'name' => 'Announcements',
                'description' => 'All of the newest information about the site',
                'order' => 1,
            ],
            [
                'parent_id' => 1,
                'slug' => 'introductions',
                'name' => 'Introductions',
                'description' => 'Why don\'t you post and introduce yourself?',
                'order' => 1,
            ],
            [
                'parent_id' => 3,
                'slug' => 'special-intros',
                'name' => 'Special Intros',
                'description' => 'Reserved for special people',
                'order' => 1,
            ],
            [
                'slug' => 'site',
                'name' => 'Site',
                'order' => 2,
            ],
            [
                'parent_id' => 5,
                'slug' => 'bugs',
                'name' => 'Bugs',
                'description' => 'Post any bugs you find on the site in here',
                'order' => 1,
            ],
            [
                'parent_id' => 5,
                'slug' => 'features',
                'name' => 'Features',
                'description' => 'All feature requests should go here',
                'order' => 2,
            ],
        ];

        Category::unguard();
        foreach ($categories as $category) {
            Category::create($category);
        }
        Category::reguard();
    }

    protected function addThreads()
    {
        $user = $this->getUser();

        // TODO
    }

    protected function getUser()
    {
        $userClass = config('liddleforum.user.model');
        return $userClass::first();
    }
}
