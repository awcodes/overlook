<?php

declare(strict_types=1);

namespace Workbench\App\Filament\Resources\Users;

use Awcodes\Overlook\Concerns\HandlesOverlookWidgetCustomization;
use Awcodes\Overlook\Contracts\CustomizeOverlookWidget;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Workbench\App\Filament\Resources\Users\Pages\CreateUser;
use Workbench\App\Filament\Resources\Users\Pages\EditUser;
use Workbench\App\Filament\Resources\Users\Pages\ListUsers;
use Workbench\App\Filament\Resources\Users\Pages\ViewUser;
use Workbench\App\Filament\Resources\Users\Schemas\UserForm;
use Workbench\App\Filament\Resources\Users\Schemas\UserInfolist;
use Workbench\App\Filament\Resources\Users\Tables\UsersTable;
use Workbench\App\Models\User;

class CustomUserResource extends Resource implements CustomizeOverlookWidget
{
    use HandlesOverlookWidgetCustomization;

    protected static ?string $model = User::class;

    protected static ?string $slug = 'users';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getOverlookWidgetQuery(Builder $query): Builder
    {
        return $query->where('email_verified_at', '=', null);
    }

    public static function getOverlookWidgetTitle(): string
    {
        return 'Unverified Users';
    }
}
