<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CastResource\Pages;
use App\Models\Cast;
use App\Models\Shop;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CastResource extends Resource
{
    protected static ?string $model = Cast::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = '店舗管理';

    protected static ?string $navigationLabel = 'キャスト';

    protected static ?string $modelLabel = 'キャスト';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('所属店舗')
                    ->schema([
                        Forms\Components\Select::make('shop_id')
                            ->label('店舗')
                            ->options(Shop::active()->pluck('name', 'id'))
                            ->required()
                            ->searchable(),
                    ]),
                Forms\Components\Section::make('基本プロフィール')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('源氏名')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('slug')
                            ->label('スラッグ')
                            ->maxLength(100)
                            ->alphaDash(),
                        Forms\Components\FileUpload::make('profile_image')
                            ->label('プロフィール画像')
                            ->image()
                            ->directory('casts/profiles')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('3:4')
                            ->imageResizeTargetWidth('600')
                            ->imageResizeTargetHeight('800'),
                        Forms\Components\TextInput::make('age')
                            ->label('年齢')
                            ->numeric()
                            ->minValue(18)
                            ->maxValue(99),
                        Forms\Components\TextInput::make('height')
                            ->label('身長 (cm)')
                            ->numeric()
                            ->minValue(100)
                            ->maxValue(200),
                        Forms\Components\Select::make('blood_type')
                            ->label('血液型')
                            ->options([
                                'A' => 'A型',
                                'B' => 'B型',
                                'O' => 'O型',
                                'AB' => 'AB型',
                            ]),
                        Forms\Components\TextInput::make('birthplace')
                            ->label('出身地')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('hobby')
                            ->label('趣味')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('special_skill')
                            ->label('特技')
                            ->maxLength(255),
                    ])->columns(2),
                Forms\Components\Section::make('紹介文')
                    ->schema([
                        Forms\Components\Textarea::make('self_introduction')
                            ->label('自己紹介')
                            ->rows(4),
                        Forms\Components\Textarea::make('message')
                            ->label('お客様へのメッセージ')
                            ->rows(4),
                    ]),
                Forms\Components\Section::make('グラビア画像')
                    ->schema([
                        Forms\Components\Repeater::make('images')
                            ->label('画像')
                            ->relationship()
                            ->schema([
                                Forms\Components\FileUpload::make('image_path')
                                    ->label('画像')
                                    ->image()
                                    ->required()
                                    ->directory('casts/images'),
                                Forms\Components\TextInput::make('alt_text')
                                    ->label('代替テキスト')
                                    ->maxLength(255),
                                Forms\Components\Select::make('image_type')
                                    ->label('種類')
                                    ->options([
                                        'profile' => 'プロフィール',
                                        'gravure' => 'グラビア',
                                        'other' => 'その他',
                                    ])
                                    ->default('gravure'),
                                Forms\Components\TextInput::make('sort_order')
                                    ->label('表示順')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->columns(2)
                            ->collapsible(),
                    ]),
                Forms\Components\Section::make('公開設定')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('公開')
                            ->default(true),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('おすすめ')
                            ->default(false),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('表示順')
                            ->numeric()
                            ->default(0),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('profile_image')
                    ->label('画像')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label('源氏名')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shop.name')
                    ->label('店舗')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('age')
                    ->label('年齢')
                    ->suffix('歳'),
                Tables\Columns\TextColumn::make('height')
                    ->label('身長')
                    ->suffix('cm'),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('おすすめ')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('公開')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('表示順')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('shop_id')
                    ->label('店舗')
                    ->options(Shop::pluck('name', 'id')),
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
            'index' => Pages\ListCasts::route('/'),
            'create' => Pages\CreateCast::route('/create'),
            'edit' => Pages\EditCast::route('/{record}/edit'),
        ];
    }
}
