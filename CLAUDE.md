# Night Web - ナイトスタイル風ポータルサイト

キャバクラ・ガールズバー専用ポータルサイト（関東エリア限定）

## 技術スタック

- **Backend**: Laravel 12 + PHP 8.2
- **Admin**: Filament v3
- **Frontend**: Blade + Tailwind CSS v4 + Alpine.js
- **Database**: MySQL
- **Environment**: Docker (nginx, php, mysql)

## 開発環境

```bash
# コンテナ起動
docker compose up -d

# アプリケーションURL
http://localhost:8080

# 管理画面
http://localhost:8080/admin
```

## よく使うコマンド

```bash
# Artisanコマンド実行
docker compose exec php php artisan <command>

# マイグレーション
docker compose exec php php artisan migrate

# シーダー実行
docker compose exec php php artisan db:seed

# ビューキャッシュクリア
docker compose exec php php artisan view:clear

# アセットビルド
docker compose exec php npm run build
```

## ディレクトリ構造

```
night_web/
├── docker/                 # Docker設定
├── docker-compose.yml
└── html/                   # Laravelアプリケーション
    ├── app/
    │   ├── Filament/Resources/   # 管理画面リソース
    │   ├── Http/Controllers/     # フロントコントローラー
    │   ├── Models/               # Eloquentモデル
    │   └── Services/             # ビジネスロジック
    ├── resources/views/          # Bladeテンプレート
    └── routes/web.php            # ルーティング
```

## アーキテクチャ

### Service層

ビジネスロジックはService層に集約。コントローラーはリクエスト処理とビュー返却のみ。

| Service | 責務 |
|---------|------|
| ShopService | 店舗検索、フィルタリング、ランキング取得 |
| CastService | キャスト取得、ブログ取得 |
| ReviewService | 口コミ投稿、評価集計 |
| MasterDataService | 都道府県、エリア、業種のマスタデータ取得 |

```php
// コントローラーでの使用例
class ShopController extends Controller
{
    public function __construct(
        private readonly ShopService $shopService,
    ) {}

    public function show(Shop $shop): View
    {
        $shop = $this->shopService->getShopWithDetails($shop);
        // ...
    }
}
```

### Form Request

バリデーションはForm Requestクラスに集約。

| Request | 用途 |
|---------|------|
| StoreReviewRequest | 口コミ投稿 |

```php
// コントローラーでの使用
public function store(StoreReviewRequest $request, Shop $shop): RedirectResponse
{
    $this->reviewService->createReview($shop, $request->validated(), $request->ip());
}
```

## 主要モデル

| Model | 説明 |
|-------|------|
| Prefecture | 都道府県 |
| Area | エリア（新宿、渋谷など） |
| Station | 駅 |
| BusinessType | 業種（キャバクラ、ガールズバーなど） |
| Shop | 店舗 |
| ShopImage | 店舗画像 |
| ShopSchedule | 営業時間 |
| Cast | キャスト |
| CastImage | キャスト画像 |
| CastBlog | キャストブログ |
| Review | 口コミ |

## 注意事項

### `castMembers()` メソッド名について

`Shop`モデルでキャストを取得するリレーションは **`castMembers()`** を使用する。

```php
// 正しい
$shop->castMembers()

// 間違い - Laravelの$castsプロパティと競合する
$shop->casts()
```

理由: Laravelは `$casts` プロパティを予約しており、`casts()` メソッドを定義すると競合が発生する。

### 画像の取得

店舗・キャストの画像は `main_image` アクセサを使用する：

```php
// Shop
$shop->main_image  // ShopImageからmainタイプを取得、なければthumbnall

// Cast
$cast->main_image  // profile_imageまたはCastImageから取得
```

### スコープ

```php
// 公開中の店舗
Shop::published()->get()

// アクティブなキャスト
Cast::active()->get()

// 承認済み口コミ
Review::approved()->get()
```

## URL構造

| URL | 説明 |
|-----|------|
| `/` | トップページ |
| `/search` | 検索結果 |
| `/ranking` | ランキング |
| `/area/{prefecture}` | 都道府県別 |
| `/area/{prefecture}/{area}` | エリア別 |
| `/genre/{business_type}` | 業種別 |
| `/shop/{slug}` | 店舗詳細 |
| `/shop/{slug}/casts` | キャスト一覧 |
| `/shop/{slug}/reviews` | 口コミ一覧 |
| `/cast/{slug}` | キャスト詳細 |
| `/cast/{slug}/blogs` | ブログ一覧 |
| `/admin` | 管理画面 |

## Filament管理画面リソース

- PrefectureResource（都道府県）
- AreaResource（エリア）
- StationResource（駅）
- BusinessTypeResource（業種）
- UserResource（ユーザー）
- ShopResource（店舗）
- CastResource（キャスト）
- CastBlogResource（ブログ）
- ReviewResource（口コミ）
