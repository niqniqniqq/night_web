<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'システム管理';

    protected static ?string $navigationLabel = 'ユーザー';

    protected static ?string $modelLabel = 'ユーザー';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('基本情報')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('名前')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('メールアドレス')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('password')
                            ->label('パスワード')
                            ->password()
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create'),
                        Forms\Components\Select::make('role')
                            ->label('権限')
                            ->options([
                                User::ROLE_ADMIN => '管理者',
                                User::ROLE_SHOP_OWNER => '店舗オーナー',
                                User::ROLE_MEMBER => '一般会員',
                            ])
                            ->required()
                            ->default(User::ROLE_ADMIN),
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
                    ->label('名前')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('メールアドレス')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label('権限')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        User::ROLE_ADMIN => '管理者',
                        User::ROLE_SHOP_OWNER => '店舗オーナー',
                        User::ROLE_MEMBER => '一般会員',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        User::ROLE_ADMIN => 'danger',
                        User::ROLE_SHOP_OWNER => 'warning',
                        User::ROLE_MEMBER => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('有効')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('作成日')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('権限')
                    ->options([
                        User::ROLE_ADMIN => '管理者',
                        User::ROLE_SHOP_OWNER => '店舗オーナー',
                        User::ROLE_MEMBER => '一般会員',
                    ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
