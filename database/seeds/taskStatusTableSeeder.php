<?php

use Illuminate\Database\Seeder;

class taskStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		/* fbsg-signature-addSeedTables:<begin> task */
		DB::table('task_statuses')->insert([
            [
             'name' =>'draft',
            ],
            [
             'name' =>'active',
            ],
            [
             'name' =>'inactive',
            ],
        ]);
		/* fbsg-signature-addSeedTables:<end> task */
    }
}
