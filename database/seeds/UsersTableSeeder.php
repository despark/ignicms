<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Despark Admin',
                'email' => 'admin@despark.com',
                'password' => bcrypt('Despark1234'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
