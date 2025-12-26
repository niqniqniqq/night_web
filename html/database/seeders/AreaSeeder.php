<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Prefecture;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        $areasByPrefecture = [
            'tokyo' => [
                ['name' => '新宿', 'slug' => 'shinjuku', 'sort_order' => 1],
                ['name' => '渋谷', 'slug' => 'shibuya', 'sort_order' => 2],
                ['name' => '池袋', 'slug' => 'ikebukuro', 'sort_order' => 3],
                ['name' => '六本木', 'slug' => 'roppongi', 'sort_order' => 4],
                ['name' => '銀座', 'slug' => 'ginza', 'sort_order' => 5],
                ['name' => '上野', 'slug' => 'ueno', 'sort_order' => 6],
                ['name' => '錦糸町', 'slug' => 'kinshicho', 'sort_order' => 7],
                ['name' => '五反田', 'slug' => 'gotanda', 'sort_order' => 8],
                ['name' => '恵比寿', 'slug' => 'ebisu', 'sort_order' => 9],
                ['name' => '中野', 'slug' => 'nakano', 'sort_order' => 10],
                ['name' => '吉祥寺', 'slug' => 'kichijoji', 'sort_order' => 11],
                ['name' => '町田', 'slug' => 'machida', 'sort_order' => 12],
                ['name' => '立川', 'slug' => 'tachikawa', 'sort_order' => 13],
                ['name' => '八王子', 'slug' => 'hachioji', 'sort_order' => 14],
                ['name' => '赤坂', 'slug' => 'akasaka', 'sort_order' => 15],
            ],
            'kanagawa' => [
                ['name' => '横浜', 'slug' => 'yokohama', 'sort_order' => 1],
                ['name' => '川崎', 'slug' => 'kawasaki', 'sort_order' => 2],
                ['name' => '関内', 'slug' => 'kannai', 'sort_order' => 3],
                ['name' => '藤沢', 'slug' => 'fujisawa', 'sort_order' => 4],
                ['name' => '溝の口', 'slug' => 'mizonokuchi', 'sort_order' => 5],
                ['name' => '本厚木', 'slug' => 'honatsugi', 'sort_order' => 6],
                ['name' => '相模大野', 'slug' => 'sagamiono', 'sort_order' => 7],
            ],
            'chiba' => [
                ['name' => '千葉', 'slug' => 'chiba-city', 'sort_order' => 1],
                ['name' => '船橋', 'slug' => 'funabashi', 'sort_order' => 2],
                ['name' => '柏', 'slug' => 'kashiwa', 'sort_order' => 3],
                ['name' => '松戸', 'slug' => 'matsudo', 'sort_order' => 4],
                ['name' => '津田沼', 'slug' => 'tsudanuma', 'sort_order' => 5],
                ['name' => '木更津', 'slug' => 'kisarazu', 'sort_order' => 6],
            ],
            'saitama' => [
                ['name' => '大宮', 'slug' => 'omiya', 'sort_order' => 1],
                ['name' => '浦和', 'slug' => 'urawa', 'sort_order' => 2],
                ['name' => '川口', 'slug' => 'kawaguchi', 'sort_order' => 3],
                ['name' => '川越', 'slug' => 'kawagoe', 'sort_order' => 4],
                ['name' => '所沢', 'slug' => 'tokorozawa', 'sort_order' => 5],
                ['name' => '越谷', 'slug' => 'koshigaya', 'sort_order' => 6],
            ],
            'gunma' => [
                ['name' => '高崎', 'slug' => 'takasaki', 'sort_order' => 1],
                ['name' => '前橋', 'slug' => 'maebashi', 'sort_order' => 2],
                ['name' => '太田', 'slug' => 'ota', 'sort_order' => 3],
            ],
            'tochigi' => [
                ['name' => '宇都宮', 'slug' => 'utsunomiya', 'sort_order' => 1],
                ['name' => '小山', 'slug' => 'oyama', 'sort_order' => 2],
            ],
            'ibaraki' => [
                ['name' => '水戸', 'slug' => 'mito', 'sort_order' => 1],
                ['name' => 'つくば', 'slug' => 'tsukuba', 'sort_order' => 2],
                ['name' => '土浦', 'slug' => 'tsuchiura', 'sort_order' => 3],
            ],
        ];

        foreach ($areasByPrefecture as $prefectureSlug => $areas) {
            $prefecture = Prefecture::where('slug', $prefectureSlug)->first();
            if (!$prefecture) {
                continue;
            }

            foreach ($areas as $area) {
                Area::firstOrCreate(
                    [
                        'prefecture_id' => $prefecture->id,
                        'slug' => $area['slug'],
                    ],
                    array_merge($area, ['prefecture_id' => $prefecture->id])
                );
            }
        }
    }
}
