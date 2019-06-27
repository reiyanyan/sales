<?php

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
        for ($i=0; $i < 30; $i++) { 
	    	DB::table('users')->insert([
	            'identitas' => str_random(8),
	            'name' => str_random(15),
	            'alamat' => str_random(20),
	            'no_hp' => str_random(12),
	            'role' => 1,
	            'email' => str_random(12).'@mail.com',
	            'password' => bcrypt('secret')
	        ]);
    	}
    }
}
