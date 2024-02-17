<?php

namespace Awcodes\Overlook\Widgets;

use Awcodes\Overlook\Contracts\CustomizeOverlookWidget;
use Awcodes\Overlook\OverlookPlugin;
use Exception;
use Filament\Widgets\Widget;
use NumberFormatter;

class OverlookWidget extends Widget
{
    protected static string $view = 'overlook::widget';

    protected int | string | array $columnSpan = 'full';

    public array $data = [];

    public array $excludes = [];

    public array $includes = [];

    public array $grid = [];

    public array $icons = [];

    /**
     * @throws Exception
     */
    public function mount(): void
    {
        $this->data = $this->getData();

        if (empty($this->grid)) {
            $this->grid = OverlookPlugin::get()->getColumns();
        }
    }

    public function convertCount(string $number): string
    {
        if (OverlookPlugin::get()->shouldAbbreviateCount()) {
            $formatter = new NumberFormatter(
                app()->getLocale(),
                NumberFormatter::PATTERN_DECIMAL,
            );

            return $formatter->format($number);
        }

        return $number;
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
        $includes = filled($this->includes) ? $this->includes : $plugin->getIncludes();
        $excludes = filled($this->excludes) ? $this->excludes : $plugin->getExcludes();
        $icons = filled($this->icons) ? $this->icons : $plugin->getIcons();

        $rawResources = filled($includes)
            ? $includes
            : filament()->getCurrentPanel()->getResources();

        return collect($rawResources)->filter(function ($resource) use ($excludes) {
            return ! in_array($resource, $excludes);
        })->transform(function ($resource) use ($icons) {

            $customIcon = array_search($resource, $icons);

            $res = app($resource);

            $widgetQuery = $res->getEloquentQuery();

            if ($res instanceof CustomizeOverlookWidget) {
                $rawCount = $res->getOverlookWidgetQuery($widgetQuery)->count();
                $title = $res->getOverlookWidgetTitle();
            } else {
                $rawCount = $widgetQuery->count();
                $title = ucfirst($res->getPluralModelLabel());
            }

            if ($res->canViewAny()) {
                return [
                    'name' => $title,
                    'raw_count' => $this->formatRawcount($rawCount),
                    'count' => $this->convertCount($rawCount),
                    'icon' => $customIcon ?: $res->getNavigationIcon(),
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
