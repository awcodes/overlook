<?php

declare(strict_types=1);

namespace Awcodes\Overlook\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface CustomizeOverlookWidget
{
    public static function getOverlookWidgetQuery(Builder $query): Builder;

    public static function getOverlookWidgetTitle(): string;
}
