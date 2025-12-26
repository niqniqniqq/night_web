<?php

namespace Database\Seeders;

use App\Models\Prefecture;
use Illuminate\Database\Seeder;

class PrefectureSeeder extends Seeder
{
    public function run(): void
    {
        $prefectures = [
            ['name' => '東京都', 'slug' => 'tokyo', 'region' => '関東', 'sort_order' => 1],
            ['name' => '神奈川県', 'slug' => 'kanagawa', 'region' => '関東', 'sort_order' => 2],
            ['name' => '千葉県', 'slug' => 'chiba', 'region' => '関東', 'sort_order' => 3],
            ['name' => '埼玉県', 'slug' => 'saitama', 'region' => '関東', 'sort_order' => 4],
            ['name' => '群馬県', 'slug' => 'gunma', 'region' => '関東', 'sort_order' => 5],
            ['name' => '栃木県', 'slug' => 'tochigi', 'region' => '関東', 'sort_order' => 6],
            ['name' => '茨城県', 'slug' => 'ibaraki', 'region' => '関東', 'sort_order' => 7],
        ];

        foreach ($prefectures as $prefecture) {
            Prefecture::firstOrCreate(
                ['slug' => $prefecture['slug']],
                $prefecture
            );
        }
    }
}
