<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		/* fbsg-signature-addSeedTables:<begin> Role */
		DB::table('roles')->insert([
            [
             'name' =>'admin',
            ],
            [
             'name' =>'staff',
            ],
            [
             'name' =>'owner',
            ],
        ]);
		/* fbsg-signature-addSeedTables:<end> Role */
    }
}
