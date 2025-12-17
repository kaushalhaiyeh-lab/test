<?php

namespace App\Filament\Resources\Roles;

use App\Filament\Resources\Roles\Pages;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static string|\UnitEnum|null $navigationGroup = 'Security';

    public static function shouldRegisterNavigation(): bool
    {
        return Gate::allows('manage_roles');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->required()
                ->unique(ignoreRecord: true)
                ->disabled(fn ($record) => $record?->name === 'super_admin'),

            CheckboxList::make('permissions')
    ->label('Permissions')
    ->relationship('permissions', 'name')
    ->columns(2)
    ->hidden(fn ($record) => $record?->name === 'super_admin'),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->badge(),
            TextColumn::make('permissions.name')
                ->label('Permissions')
                ->limit(3),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit'   => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
