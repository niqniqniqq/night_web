<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StationResource\Pages;
use App\Models\Area;
use App\Models\Prefecture;
use App\Models\Station;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StationResource extends Resource
{
    protected static ?string $model = Station::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'マスタ管理';

    protected static ?string $navigationLabel = '駅';

    protected static ?string $modelLabel = '駅';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
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
                            ->searchable(),
                        Forms\Components\TextInput::make('name')
                            ->label('駅名')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('slug')
                            ->label('スラッグ')
                            ->required()
                            ->maxLength(50)
                            ->alphaDash(),
                        Forms\Components\TextInput::make('line_name')
                            ->label('路線名')
                            ->maxLength(50),
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
                Tables\Columns\TextColumn::make('area.prefecture.name')
                    ->label('都道府県')
                    ->sortable(),
                Tables\Columns\TextColumn::make('area.name')
                    ->label('エリア')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('駅名')
                    ->searchable(),
                Tables\Columns\TextColumn::make('line_name')
                    ->label('路線名'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('表示順')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('有効')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('area_id')
                    ->label('エリア')
                    ->options(Area::with('prefecture')->get()->pluck('name', 'id')),
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
            'index' => Pages\ListStations::route('/'),
            'create' => Pages\CreateStation::route('/create'),
            'edit' => Pages\EditStation::route('/{record}/edit'),
        ];
    }
}
