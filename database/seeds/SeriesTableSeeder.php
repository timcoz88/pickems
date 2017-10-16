<?php

use Illuminate\Database\Seeder;

use App\Series;

class SeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	factory( Series::class, 10 )->create();
    }
}
