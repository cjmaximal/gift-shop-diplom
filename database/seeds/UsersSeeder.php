<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       \App\User::create([
            'name'     => 'Администратор',
            'email'    => 'cjmaximal-r16@yandex.ru',
            'phone'    => '71234567890',
            'password' => '123456',
            'is_admin' => true,
        ]);
    }
}
