<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::factory(1)->create([
            'email' => 'testing@email.com',
            'username' => 'testing',
            'iam_is' => User::ROLE_ADMIN,
        ]);

        User::factory(5)->create();
    }
}
