<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // max => barem da stvori jedan user
        // kastamo u integer
        $usersCount = max((int)$this->command->ask('How many users would you like?', 20), 1);
        $doe = factory(User::class)->states('john-doe')->create();
        $else = factory(User::class, $usersCount)->create();

        // $users = $else->concat([$doe]);
    }
}
