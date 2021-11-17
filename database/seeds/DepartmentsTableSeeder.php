<?php

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::insert([
            ['name' => 'College of Information Technology and Computer Science'],
            ['name' => 'College of Information Technology and Computer Science'],
        ]);
    }
}
