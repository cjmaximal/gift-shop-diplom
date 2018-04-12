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
            'email'    => 'Xaxaker1@bk.ru',
            'phone'    => '5555555',
            'password' => '123456',
            'is_admin' => true,
        ]);
    }
}
