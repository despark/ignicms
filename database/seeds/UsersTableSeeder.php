<?php

use Illuminate\Database\Seeder;
use Despark\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Despark Admin',
                'email' => 'admin@despark.com',
                'password' => bcrypt('Despark1234')
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
