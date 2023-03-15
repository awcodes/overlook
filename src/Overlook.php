<?php

namespace Awcodes\Overlook;

use Filament\Facades\Filament;
use Filament\Widgets\Widget;
use Illuminate\Support\Str;

class Overlook extends Widget
{
    protected static string $view = 'overlook::widget';

    protected int | string | array $columnSpan = 'full';

    public array $data = [];

    private array $excludes = [];

    public function mount(): void
    {
        $this->data = $this->getData();
    }

    public function getData(): array
    {
        $rawResources = Filament::getResources();

        return collect($rawResources)->filter(function ($resource) {
            return ! in_array(Str::of($resource)->afterLast('\\'), $this->excludes);
        })->transform(function ($resource) {
            $res = app($resource);
            $model = $res->getModel();

            if ($res->canViewAny()) {
                return [
                    'name' => ucfirst($res->getPluralModelLabel()),
                    'count' => $model::count(),
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
