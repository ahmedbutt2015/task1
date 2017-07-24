<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Ahmed Butt',
            'username' => 'ahmed' . rand(10, 100),
            'password' => bcrypt('123456'),
            'image' => 'admin.jpg',
            'role_id' => \App\Role::where('name', 'admin')->first()->id,
        ]);
    }
}
