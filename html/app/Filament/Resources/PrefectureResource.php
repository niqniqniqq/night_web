<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrefectureResource\Pages;
use App\Models\Prefecture;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PrefectureResource extends Resource
{
    protected static ?string $model = Prefecture::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'マスタ管理';

    protected static ?string $navigationLabel = '都道府県';

    protected static ?string $modelLabel = '都道府県';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('都道府県名')
                            ->required()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('slug')
                            ->label('スラッグ')
                            ->required()
                            ->maxLength(20)
                            ->unique(ignoreRecord: true)
                            ->alphaDash(),
                        Forms\Components\TextInput::make('region')
                            ->label('地方')
                            ->default('関東')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('表示順')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->label('有効')
                            ->default(true),
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
                Tables\Columns\TextColumn::make('name')
                    ->label('都道府県名')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('スラッグ')
                    ->searchable(),
                Tables\Columns\TextColumn::make('region')
                    ->label('地方'),
                Tables\Columns\TextColumn::make('areas_count')
                    ->label('エリア数')
                    ->counts('areas'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('表示順')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('有効')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('有効'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPrefectures::route('/'),
            'create' => Pages\CreatePrefecture::route('/create'),
            'edit' => Pages\EditPrefecture::route('/{record}/edit'),
        ];
    }
}
