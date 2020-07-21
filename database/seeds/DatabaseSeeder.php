<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserSeeder::class);
		/* fbsg-signature-addSeedTables:<begin> */
         $this->call(taskStatusTableSeeder::class);
         $this->call(RoleTableSeeder::class);
		/* fbsg-signature-addSeedTables:<end> */
    }
}
