<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if($this->command->confirm("Do you want to refresh the database?")) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed');
        }

        // composer dump-autoload uvijek moramo pokrenuti svaki put kad stvoorimo novu seeder klasu!!!!!
        // BITAN JE REDOSLJED KAKO SE POZIVAJU (users, blogpost, comments) mora biti logicki slozeno
        $this->call([
            UsersTableSeeder::class,
            BlogPostsTableSeeder::class,
            CommentsTableSeeder::class
        ]);
    }
}
