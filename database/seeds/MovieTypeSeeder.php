<?php

use Illuminate\Database\Seeder;
use App\MovieType;

class MovieTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\MovieType::class,50)->create();
    }
}
