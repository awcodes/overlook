---
title: Customizing resources
description: Override the count query or card title for an individual resource.
---

# Customizing resources

The plugin settings apply to every card. To change how one particular resource is counted or labelled, implement `CustomizeOverlookWidget` on that resource.

## Opting a resource in

Implement the interface and use the trait that satisfies it:

```php
use Awcodes\Overlook\Concerns\HandlesOverlookWidgetCustomization;
use Awcodes\Overlook\Contracts\CustomizeOverlookWidget;

class UserResource extends Resource implements CustomizeOverlookWidget
{
    use HandlesOverlookWidgetCustomization;
}
```

The interface requires two static methods. The trait supplies both with the same behaviour Overlook uses by default, so a resource that implements the interface and uses the trait — and overrides nothing — renders exactly as it did before. Override only what you need.

## Customizing the query

`getOverlookWidgetQuery()` receives the query Overlook was going to count and returns the one it should count instead:

```php
use Illuminate\Database\Eloquent\Builder;

public static function getOverlookWidgetQuery(Builder $query): Builder
{
    return $query->where('status', '=', 'PENDING');
}
```

The query handed in is the resource's own `getEloquentQuery()`, with soft-deleted records already excluded if you enabled [`withoutTrashed()`](configuration.md). Building on it rather than starting fresh keeps global scopes and tenancy intact.

This is the method to reach for when the useful number is not "how many exist" but "how many need attention" — pending orders, unmoderated comments, expiring subscriptions.

> [!NOTE]
> The card still links to the resource's unfiltered index page. A count narrowed to pending records will not match what the user sees when they follow it, so it is worth naming the card accordingly.

## Customizing the title

`getOverlookWidgetTitle()` sets the card's label:

```php
public static function getOverlookWidgetTitle(): string
{
    return 'Pending Users';
}
```

Left alone, the trait returns the resource's plural model label, capitalised — the same title an uncustomised resource gets.

Pairing the two overrides is the usual case: a narrowed query with a title that says so.

```php
use Awcodes\Overlook\Concerns\HandlesOverlookWidgetCustomization;
use Awcodes\Overlook\Contracts\CustomizeOverlookWidget;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource implements CustomizeOverlookWidget
{
    use HandlesOverlookWidgetCustomization;

    public static function getOverlookWidgetQuery(Builder $query): Builder
    {
        return $query->where('status', '=', 'PENDING');
    }

    public static function getOverlookWidgetTitle(): string
    {
        return 'Pending Orders';
    }
}
```

## Icons

Icons are not part of this interface — they are set centrally on the plugin, keyed by icon name. See [Icons](configuration.md) in the configuration.
