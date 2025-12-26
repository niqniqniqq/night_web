<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessTypeResource\Pages;
use App\Models\BusinessType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BusinessTypeResource extends Resource
{
    protected static ?string $model = BusinessType::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'マスタ管理';

    protected static ?string $navigationLabel = '業種';

    protected static ?string $modelLabel = '業種';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('業種名')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('slug')
                            ->label('スラッグ')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true)
                            ->alphaDash(),
                        Forms\Components\Textarea::make('description')
                            ->label('説明')
                            ->rows(3),
                        Forms\Components\TextInput::make('icon')
                            ->label('アイコン')
                            ->maxLength(50)
                            ->placeholder('heroicon-o-star'),
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
                    ->label('業種名')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('スラッグ'),
                Tables\Columns\TextColumn::make('shops_count')
                    ->label('店舗数')
                    ->counts('shops'),
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
            'index' => Pages\ListBusinessTypes::route('/'),
            'create' => Pages\CreateBusinessType::route('/create'),
            'edit' => Pages\EditBusinessType::route('/{record}/edit'),
        ];
    }
}
