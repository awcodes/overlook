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
            ->sortBy('name')
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
            $formattedNum = match (true) {
                strlen($number) >= 13 => bcdiv($number, '1000000000000', 1) . 'T',
                strlen($number) >= 10 => bcdiv($number, '1000000000', 1) . 'B',
                strlen($number) >= 7 => bcdiv($number, '1000000', 1) . 'M',
                strlen($number) >= 4 => bcdiv($number, '1000', 1) . 'K',
                default => $number,
            };

            // Remove .0 from numbers like 1.0 as it's not needed for counts
            $formattedNum = str_replace('.0', '', $formattedNum);

            return $formattedNum;
        }

        return $number;
    }

    public function shouldShowTooltip(string $number): bool
    {
        return strlen($number) >= 4 && config('overlook.should_convert_count') && config('overlook.enable_convert_tooltip');
    }
}
