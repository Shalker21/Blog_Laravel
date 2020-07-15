<?php

use App\User;
use App\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blogPostCount = (int)$this->command->ask('How many blog posts would you like?', 50);
        $users = User::all();

         // koristimo key use kako bi koristili podatke usera!!
         $posts = factory(BlogPost::class, $blogPostCount)->make()->each(function($post) use ($users) {
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
