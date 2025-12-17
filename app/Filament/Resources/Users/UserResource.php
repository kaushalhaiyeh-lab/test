<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|\UnitEnum|null $navigationGroup = 'User Management';

    public static function shouldRegisterNavigation(): bool
    {
        return Gate::allows('manage_users');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),

            TextInput::make('password')
                ->password()
                ->required(fn ($record) => $record === null)
                ->dehydrateStateUsing(
                    fn ($state) => filled($state) ? Hash::make($state) : null
                )
                ->dehydrated(fn ($state) => filled($state)),

            Select::make('roles')
                ->label('Role')
                ->relationship('roles', 'name')
                ->options(fn () =>
                    Gate::allows('manage_roles')
                        ? Role::pluck('name', 'name')
                        : Role::where('name', 'hr')->pluck('name', 'name')
                )
                ->required()
                ->preload(),
        ]);
    }

    public static function table(Table $table): Table
{
    return $table->columns([
        TextColumn::make('name')->searchable(),
        TextColumn::make('email')->searchable(),
        TextColumn::make('roles.name')
            ->label('Role')
            ->badge(),
        TextColumn::make('created_at')->dateTime(),
    ]);
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
