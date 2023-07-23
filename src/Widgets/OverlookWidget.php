<?php

namespace Awcodes\Overlook\Widgets;

use Awcodes\Overlook\OverlookPlugin;
use Exception;
use Filament\Widgets\Widget;
use NumberFormatter;

class OverlookWidget extends Widget
{
    protected static string $view = 'overlook::widget';

    protected int | string | array $columnSpan = 'full';

    public array $data = [];

    protected array $excludes = [];

    protected array $includes = [];

    public array $grid = [];

    /**
     * @throws Exception
     */
    public function mount(): void
    {
        $this->data = $this->getData();
        $this->grid = OverlookPlugin::get()->getColumns();
    }

    public function convertCount(string $number): string
    {
        if (OverlookPlugin::get()->shouldAbbreviateCount()) {
            $formatter = new NumberFormatter(
                app()->getLocale(),
                NumberFormatter::PADDING_POSITION,
            );

            return $formatter->format($number);
        }

        return $number;
    }

    public function shouldLoadCss(): bool
    {
        return OverlookPlugin::get()->shouldLoadCss();
    }

    public function formatRawCount(string $number): string
    {
        return number_format($number);
    }

    /**
     * @throws Exception
     */
    public function getData(): array
    {
        $plugin = OverlookPlugin::get();

        $rawResources = filled($plugin->getIncludes())
            ? $plugin->getIncludes()
            : filament()->getCurrentPanel()->getResources();

        return collect($rawResources)->filter(function ($resource) use ($plugin) {
            return ! in_array($resource, $plugin->getExcludes());
        })->transform(function ($resource) {
            $res = app($resource);
            $rawCount = $res->getEloquentQuery()->count();

            if ($res->canViewAny()) {
                return [
                    'name' => ucfirst($res->getPluralModelLabel()),
                    'raw_count' => $this->formatRawcount($rawCount),
                    'count' => $this->convertCount($rawCount),
                    'icon' => $res->getNavigationIcon(),
                    'url' => $res->getUrl('index'),
                ];
            }

            return null;
        })
            ->filter()
            ->when($plugin->shouldSortAlphabetical(), fn ($collection) => $collection->sortBy('name'))
            ->values()
            ->toArray();
    }

    public static function getSort(): int
    {
        return OverlookPlugin::get()->getSort();
    }

    public function shouldShowTooltips(string $number): bool
    {
        $plugin = OverlookPlugin::get();

        return strlen($number) >= 4 && $plugin->shouldAbbreviateCount() && $plugin->shouldShowTooltips();
    }
}
