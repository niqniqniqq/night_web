<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CastBlogResource\Pages;
use App\Models\Cast;
use App\Models\CastBlog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CastBlogResource extends Resource
{
    protected static ?string $model = CastBlog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = '店舗管理';

    protected static ?string $navigationLabel = 'キャストブログ';

    protected static ?string $modelLabel = 'キャストブログ';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('cast_id')
                            ->label('キャスト')
                            ->options(Cast::with('shop')->get()->mapWithKeys(fn ($cast) => [
                                $cast->id => $cast->shop->name . ' / ' . $cast->name
                            ]))
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('title')
                            ->label('タイトル')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->label('スラッグ')
                            ->maxLength(255)
                            ->alphaDash(),
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('サムネイル')
                            ->image()
                            ->directory('casts/blogs'),
                        Forms\Components\RichEditor::make('content')
                            ->label('本文')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_published')
                            ->label('公開')
                            ->default(true),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('公開日時'),
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
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('画像'),
                Tables\Columns\TextColumn::make('title')
                    ->label('タイトル')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('cast.name')
                    ->label('キャスト')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cast.shop.name')
                    ->label('店舗'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('公開')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('公開日')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('view_count')
                    ->label('閲覧数')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('公開'),
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
            'index' => Pages\ListCastBlogs::route('/'),
            'create' => Pages\CreateCastBlog::route('/create'),
            'edit' => Pages\EditCastBlog::route('/{record}/edit'),
        ];
    }
}
