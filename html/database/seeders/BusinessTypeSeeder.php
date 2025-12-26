<?php

namespace Database\Seeders;

use App\Models\BusinessType;
use Illuminate\Database\Seeder;

class BusinessTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'キャバクラ',
                'slug' => 'cabakura',
                'description' => '女性キャストが接客するナイトクラブ。華やかな内装とドレスアップしたキャストが特徴。',
                'icon' => 'heroicon-o-sparkles',
                'sort_order' => 1,
            ],
            [
                'name' => 'クラブ',
                'slug' => 'club',
                'description' => '高級感のある大人の社交場。落ち着いた雰囲気で会話を楽しめる。',
                'icon' => 'heroicon-o-building-library',
                'sort_order' => 2,
            ],
            [
                'name' => 'ガールズバー',
                'slug' => 'girls-bar',
                'description' => 'カウンター越しに女性バーテンダーと会話を楽しむバー形式のお店。',
                'icon' => 'heroicon-o-beaker',
                'sort_order' => 3,
            ],
            [
                'name' => 'スナック',
                'slug' => 'snack',
                'description' => 'ママやチーママが営むアットホームな雰囲気のお店。カラオケが楽しめることも。',
                'icon' => 'heroicon-o-musical-note',
                'sort_order' => 4,
            ],
            [
                'name' => 'ラウンジ',
                'slug' => 'lounge',
                'description' => 'ソファ席でくつろぎながら接客を受けられる落ち着いた雰囲気のお店。',
                'icon' => 'heroicon-o-home-modern',
                'sort_order' => 5,
            ],
            [
                'name' => 'コンセプトカフェ',
                'slug' => 'concafe',
                'description' => 'メイドカフェやコスプレカフェなど、特定のコンセプトを持ったカフェ形式のお店。',
                'icon' => 'heroicon-o-heart',
                'sort_order' => 6,
            ],
            [
                'name' => 'パブ',
                'slug' => 'pub',
                'description' => 'お酒を飲みながら女性スタッフとの会話を楽しむカジュアルなお店。',
                'icon' => 'heroicon-o-chat-bubble-left-right',
                'sort_order' => 7,
            ],
        ];

        foreach ($types as $type) {
            BusinessType::firstOrCreate(
                ['slug' => $type['slug']],
                $type
            );
        }
    }
}
