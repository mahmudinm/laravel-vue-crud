<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(\App\Item::class, 50)->create();
        factory(\App\Box::class, 30)->create();
    		
    }
}
