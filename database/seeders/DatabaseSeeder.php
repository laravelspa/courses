<?php

namespace Database\Seeders;

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
        \App\Models\User::factory(100)->create();
        \App\Models\Course::factory(100)->create();
        \App\Models\Student::factory(100)->create();
        \App\Models\Event::factory(100)->create();
        \App\Models\Program::factory(100)->create();
        \App\Models\Table::factory(100)->create();
    }
}
