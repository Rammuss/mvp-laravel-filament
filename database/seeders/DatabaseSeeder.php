<?php

namespace Database\Seeders;

use App\Models\Page;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Page::firstOrCreate(
            ['slug' => 'home'],
            ['title' => 'Home']
        );
    }
}
