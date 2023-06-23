<?php

namespace Awcodes\Overlook;

use Filament\Facades\Filament;
use Filament\Widgets\Widget;

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
            $rawCount = $res::getEloquentQuery()->count();

            if ($res->canViewAny()) {
                return [
                    'name' => ucfirst($res->getPluralModelLabel()),
                    'raw_count' => $this->formatRawCount($rawCount),
                    'count' => $this->convertCount($rawCount),
                    'icon' => invade($res)->getNavigationIcon(),
                    'url' => $res->getUrl('index'),
                ];
            }

            return null;
        })
            ->filter()
            ->when(config('overlook.sort'), function ($collection) {
                return $collection->sortBy('name');
            })
            ->values()
            ->toArray();
    }

    public function formatRawCount(string $number): string
    {
        return number_format($number);
    }

    public function convertCount(string $number): string
    {
        if (config('overlook.should_convert_count')) {
            $formatter = new \NumberFormatter(
                app()->getLocale(),
                \NumberFormatter::PADDING_POSITION,
            );

            return $formatter->format($number);
        }

        return $number;
    }

    public function shouldShowTooltip(string $number): bool
    {
        return strlen($number) >= 4 && config('overlook.should_convert_count') && config('overlook.enable_convert_tooltip');
    }
}
