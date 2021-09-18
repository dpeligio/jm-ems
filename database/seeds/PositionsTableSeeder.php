<?php

use Illuminate\Database\Seeder;
use App\Models\Configuration\Position;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::insert([
            ['name' => 'Chairman'],
            ['name' => 'Vice-Chairman'],
            ['name' => 'Treasurer'],
            ['name' => 'Secretary']
        ]);
    }
}
