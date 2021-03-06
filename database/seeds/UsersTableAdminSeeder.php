<?php

use Illuminate\Database\Seeder;

class UsersTableAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->insert([
    		'name'		=> 'Administrator',
    		'email'		=> 'hostmaster@localhost',
    		'password'	=> bcrypt('admin'),
    		'is_admin'	=> 1,
    	]);
    }
}
