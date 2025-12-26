<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use App\Models\Shop;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = '店舗管理';

    protected static ?string $navigationLabel = '口コミ';

    protected static ?string $modelLabel = '口コミ';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('店舗・投稿者情報')
                    ->schema([
                        Forms\Components\Select::make('shop_id')
                            ->label('店舗')
                            ->options(Shop::pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->disabled(),
                        Forms\Components\TextInput::make('nickname')
                            ->label('ニックネーム')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\DatePicker::make('visit_date')
                            ->label('来店日'),
                    ])->columns(3),
                Forms\Components\Section::make('口コミ内容')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('タイトル')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('content')
                            ->label('本文')
                            ->required()
                            ->rows(5),
                    ]),
                Forms\Components\Section::make('評価')
                    ->schema([
                        Forms\Components\Select::make('rating_overall')
                            ->label('総合評価')
                            ->options([1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'])
                            ->required(),
                        Forms\Components\Select::make('rating_service')
                            ->label('接客評価')
                            ->options([1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'])
                            ->required(),
                        Forms\Components\Select::make('rating_atmosphere')
                            ->label('雰囲気評価')
                            ->options([1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'])
                            ->required(),
                        Forms\Components\Select::make('rating_cost_performance')
                            ->label('コスパ評価')
                            ->options([1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'])
                            ->required(),
                    ])->columns(4),
                Forms\Components\Section::make('公開設定')
                    ->schema([
                        Forms\Components\Toggle::make('is_approved')
                            ->label('承認済み')
                            ->default(false),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('おすすめ')
                            ->default(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('shop.name')
                    ->label('店舗')
                    ->searchable()
                    ->limit(20),
                Tables\Columns\TextColumn::make('nickname')
                    ->label('ニックネーム')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('タイトル')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('rating_overall')
                    ->label('総合')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\ToggleColumn::make('is_approved')
                    ->label('承認'),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('おすすめ')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('投稿日')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('承認状態')
                    ->placeholder('すべて')
                    ->trueLabel('承認済み')
                    ->falseLabel('未承認'),
                Tables\Filters\SelectFilter::make('shop_id')
                    ->label('店舗')
                    ->options(Shop::pluck('name', 'id')),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::pending()->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
