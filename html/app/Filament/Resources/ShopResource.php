<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShopResource\Pages;
use App\Models\Area;
use App\Models\BusinessType;
use App\Models\Prefecture;
use App\Models\Shop;
use App\Models\ShopSchedule;
use App\Models\Station;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ShopResource extends Resource
{
    protected static ?string $model = Shop::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = '店舗管理';

    protected static ?string $navigationLabel = '店舗';

    protected static ?string $modelLabel = '店舗';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('店舗情報')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('基本情報')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('店舗名')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('slug')
                                            ->label('スラッグ')
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true)
                                            ->alphaDash(),
                                        Forms\Components\TextInput::make('catch_copy')
                                            ->label('キャッチコピー')
                                            ->maxLength(255),
                                        Forms\Components\Select::make('prefecture_id')
                                            ->label('都道府県')
                                            ->options(Prefecture::active()->ordered()->pluck('name', 'id'))
                                            ->required()
                                            ->searchable()
                                            ->live()
                                            ->dehydrated(false)
                                            ->afterStateUpdated(fn (Forms\Set $set) => $set('area_id', null)),
                                        Forms\Components\Select::make('area_id')
                                            ->label('エリア')
                                            ->options(function (Get $get) {
                                                $prefectureId = $get('prefecture_id');
                                                if (!$prefectureId) {
                                                    return [];
                                                }
                                                return Area::where('prefecture_id', $prefectureId)
                                                    ->active()
                                                    ->ordered()
                                                    ->pluck('name', 'id');
                                            })
                                            ->required()
                                            ->searchable()
                                            ->live()
                                            ->afterStateUpdated(fn (Forms\Set $set) => $set('station_id', null)),
                                        Forms\Components\Select::make('station_id')
                                            ->label('最寄り駅')
                                            ->options(function (Get $get) {
                                                $areaId = $get('area_id');
                                                if (!$areaId) {
                                                    return [];
                                                }
                                                return Station::where('area_id', $areaId)
                                                    ->active()
                                                    ->ordered()
                                                    ->pluck('name', 'id');
                                            })
                                            ->searchable(),
                                        Forms\Components\CheckboxList::make('businessTypes')
                                            ->label('業種')
                                            ->relationship('businessTypes', 'name')
                                            ->columns(3)
                                            ->required(),
                                    ])->columns(2),
                                Forms\Components\Section::make('説明')
                                    ->schema([
                                        Forms\Components\RichEditor::make('description')
                                            ->label('店舗説明')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('連絡先・アクセス')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('phone')
                                            ->label('電話番号')
                                            ->tel()
                                            ->maxLength(20),
                                        Forms\Components\TextInput::make('official_url')
                                            ->label('公式サイト')
                                            ->url()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('address')
                                            ->label('住所')
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('building')
                                            ->label('ビル名・階数')
                                            ->maxLength(255),
                                        Forms\Components\Textarea::make('access')
                                            ->label('アクセス')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ])->columns(2),
                            ]),
                        Forms\Components\Tabs\Tab::make('料金・システム')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\RichEditor::make('price_info')
                                            ->label('料金情報'),
                                        Forms\Components\RichEditor::make('system_info')
                                            ->label('システム情報'),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('画像')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\FileUpload::make('thumbnail')
                                            ->label('サムネイル画像')
                                            ->image()
                                            ->directory('shops/thumbnails')
                                            ->imageResizeMode('cover')
                                            ->imageCropAspectRatio('4:3')
                                            ->imageResizeTargetWidth('800')
                                            ->imageResizeTargetHeight('600'),
                                        Forms\Components\Repeater::make('images')
                                            ->label('店舗画像')
                                            ->relationship()
                                            ->schema([
                                                Forms\Components\FileUpload::make('image_path')
                                                    ->label('画像')
                                                    ->image()
                                                    ->required()
                                                    ->directory('shops/images'),
                                                Forms\Components\TextInput::make('alt_text')
                                                    ->label('代替テキスト')
                                                    ->maxLength(255),
                                                Forms\Components\Select::make('image_type')
                                                    ->label('種類')
                                                    ->options([
                                                        'main' => 'メイン',
                                                        'interior' => '内装',
                                                        'exterior' => '外観',
                                                        'menu' => 'メニュー',
                                                    ])
                                                    ->default('main'),
                                                Forms\Components\TextInput::make('sort_order')
                                                    ->label('表示順')
                                                    ->numeric()
                                                    ->default(0),
                                            ])
                                            ->columns(2)
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => $state['alt_text'] ?? '画像'),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('営業時間')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\Repeater::make('schedules')
                                            ->label('営業スケジュール')
                                            ->relationship()
                                            ->schema([
                                                Forms\Components\Select::make('day_of_week')
                                                    ->label('曜日')
                                                    ->options(ShopSchedule::DAYS)
                                                    ->required(),
                                                Forms\Components\Toggle::make('is_closed')
                                                    ->label('定休日')
                                                    ->live(),
                                                Forms\Components\TimePicker::make('open_time')
                                                    ->label('開店時間')
                                                    ->seconds(false)
                                                    ->hidden(fn (Get $get) => $get('is_closed')),
                                                Forms\Components\TimePicker::make('close_time')
                                                    ->label('閉店時間')
                                                    ->seconds(false)
                                                    ->hidden(fn (Get $get) => $get('is_closed')),
                                                Forms\Components\TextInput::make('note')
                                                    ->label('備考')
                                                    ->maxLength(255),
                                            ])
                                            ->columns(5)
                                            ->defaultItems(7)
                                            ->reorderable(false),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('公開設定')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\Toggle::make('is_active')
                                            ->label('公開')
                                            ->default(true),
                                        Forms\Components\Toggle::make('is_featured')
                                            ->label('おすすめ')
                                            ->default(false),
                                        Forms\Components\DateTimePicker::make('published_at')
                                            ->label('公開日時'),
                                    ])->columns(3),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('画像')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label('店舗名')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('area.name')
                    ->label('エリア')
                    ->sortable(),
                Tables\Columns\TextColumn::make('businessTypes.name')
                    ->label('業種')
                    ->badge(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('電話番号'),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('おすすめ')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('公開')
                    ->boolean(),
                Tables\Columns\TextColumn::make('view_count')
                    ->label('閲覧数')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('作成日')
                    ->dateTime('Y/m/d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('area_id')
                    ->label('エリア')
                    ->options(Area::with('prefecture')->get()->mapWithKeys(fn ($area) => [
                        $area->id => $area->prefecture->name . ' / ' . $area->name
                    ])),
                Tables\Filters\SelectFilter::make('businessTypes')
                    ->label('業種')
                    ->relationship('businessTypes', 'name'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('公開'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('おすすめ'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShops::route('/'),
            'create' => Pages\CreateShop::route('/create'),
            'edit' => Pages\EditShop::route('/{record}/edit'),
        ];
    }
}
