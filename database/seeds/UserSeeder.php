<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run()
    {
        User::firstOrCreate(
            [
                'email'=>"admin@email.com"
            ],
            [
                'name'=> 'Administrador',
                'password'=> bcrypt('12345678')
            ]
        );
    }
}
