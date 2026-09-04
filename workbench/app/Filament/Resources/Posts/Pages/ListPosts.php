<?php

declare(strict_types=1);

namespace Workbench\App\Filament\Resources\Posts\Pages;

use Filament\Resources\Pages\ListRecords;
use Workbench\App\Filament\Resources\Posts\PostResource;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;
}
