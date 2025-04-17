<?php

namespace Awcodes\Overlook\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HandlesOverlookWidgetCustomization
{
    public static ?string $title = null;

    public static function getOverlookWidgetQuery(Builder $query): Builder
    {
        return $query;
    }

    public static function getOverlookWidgetTitle(): string
    {
        return $title ?? ucfirst(self::getPluralModelLabel());
    }
}
