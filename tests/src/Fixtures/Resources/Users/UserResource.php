<?php

declare(strict_types=1);

namespace Awcodes\Overlook\Tests\Fixtures\Resources\Users;

use Awcodes\Overlook\Tests\Fixtures\Models\User;
use Awcodes\Overlook\Tests\Fixtures\Resources\Users\Pages\CreateUser;
use Awcodes\Overlook\Tests\Fixtures\Resources\Users\Pages\EditUser;
use Awcodes\Overlook\Tests\Fixtures\Resources\Users\Pages\ListUsers;
use Awcodes\Overlook\Tests\Fixtures\Resources\Users\Pages\ViewUser;
use Awcodes\Overlook\Tests\Fixtures\Resources\Users\Schemas\UserForm;
use Awcodes\Overlook\Tests\Fixtures\Resources\Users\Schemas\UserInfolist;
use Awcodes\Overlook\Tests\Fixtures\Resources\Users\Tables\UsersTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

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
}
