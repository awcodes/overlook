<?php

namespace Awcodes\Overlook;

use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Widgets\Widget;
use Illuminate\Support\Str;

class Overlook extends Widget
{
    protected static string $view = 'overlook::widget';

    protected int | string | array $columnSpan = 'full';

    public array $data = [];

    protected array $excludes = [];

    protected array $includes = [];

    public function mount(): void
    {
        $this->data = $this->getData();
    }

    public function getIncludes(): array
    {
        return $this->includes = config('overlook.includes');
    }

    public function getExcludes(): array
    {
        return $this->excludes = config('overlook.excludes');
    }

    public function getData(): array
    {
        $rawResources = filled($this->getIncludes())
            ? $this->getIncludes()
            : Filament::getResources();

        return collect($rawResources)->filter(function ($resource) {
            return ! in_array($resource, $this->getExcludes());
        })->transform(function ($resource) {
            $res = app($resource);

            if ($res->canViewAny()) {
                return [
                    'name' => ucfirst($res->getPluralModelLabel()),
                    'count' => $res::getEloquentQuery()->count(),
                    'icon' => invade($res)->getNavigationIcon(),
                    'url' => $res->getUrl('index'),
                ];
            }

            return null;
        })
            ->filter()
            ->sortBy('name')
            ->values()
            ->toArray();
    }
}
