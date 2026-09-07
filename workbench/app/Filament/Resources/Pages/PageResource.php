<?php

declare(strict_types=1);

namespace Workbench\App\Filament\Resources\Pages;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Workbench\App\Filament\Resources\Pages\Pages\ListPages;
use Workbench\App\Models\Page;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedDocument;

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPages::route('/'),
        ];
    }
}
