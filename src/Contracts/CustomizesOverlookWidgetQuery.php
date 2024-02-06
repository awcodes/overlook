<?php

namespace Awcodes\Overlook\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface CustomizesOverlookWidgetQuery
{
    public static function getOverlookWidgetQuery(Builder $query): Builder;
}