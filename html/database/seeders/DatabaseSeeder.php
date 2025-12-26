<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            PrefectureSeeder::class,
            AreaSeeder::class,
            BusinessTypeSeeder::class,
        ]);
    }
}
