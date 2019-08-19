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
		$faker = Faker\Factory::create();
        for ($i=1; $i < 31; $i++) { 
	    	DB::table('tb_pictures')->insert([
				'laporan_id' => $i,
				'foto' => 'carbon.png',
	        ]);
    	}
    }
}
