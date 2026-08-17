---
title: Configuration
description: Set Overlook's layout, ordering, resource list, count formatting, and icons on the plugin.
---

# Configuration

Everything is set with chained methods on `OverlookPlugin` in your panel provider.

## Widget position

`sort()` sets the widget's position among the dashboard's other widgets:

```php
use Awcodes\Overlook\OverlookPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            OverlookPlugin::make()
                ->sort(2),
        ]);
}
```

Lower numbers appear first. Overlook sorts at `-1` when you do not set one, which is the same value Filament gives a widget that sets no sort of its own — so among all-default widgets the order comes down to registration. Set this explicitly when Overlook needs to sit above or below something in particular.

## Columns

`columns()` sets how many cards sit side by side at each breakpoint:

```php
OverlookPlugin::make()
    ->columns([
        'default' => 1,
        'sm' => 2,
        'md' => 3,
        'lg' => 4,
        'xl' => 5,
    ])
```

Without it, the widget renders a single column at every width, so setting this is usually the first thing you want to do.

Keys are Filament's breakpoint names, and any you leave out inherit the next smallest. Passing a plain integer instead of an array sets the `lg` breakpoint only.

> [!NOTE]
> The `2xl` breakpoint is accepted by the configuration but is not applied by the widget — `xl` is the largest breakpoint that takes effect. Setting `2xl` does nothing rather than erroring.

## Choosing resources

### Excluding

`excludes()` drops resources from the widget, keeping everything else:

```php
use Awcodes\Overlook\OverlookPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            OverlookPlugin::make()
                ->excludes([
                    \App\Filament\Resources\Shop\ProductResource::class,
                    \App\Filament\Resources\Shop\OrderResource::class,
                ]),
        ]);
}
```

### Including

`includes()` inverts it — only what you name appears:

```php
OverlookPlugin::make()
    ->includes([
        \App\Filament\Resources\Shop\ProductResource::class,
        \App\Filament\Resources\Shop\OrderResource::class,
    ])
```

> [!WARNING]
> Use one or the other, not both. `includes()` replaces the resource list outright and `excludes()` then filters whatever remains, so combining them can only subtract from what you included.

Authorization applies either way: a resource named in `includes()` still disappears for a user whose `canViewAny()` returns false.

## Ordering the cards

Cards follow the order resources were registered with Filament, or the order given to `includes()`. `alphabetical()` sorts them by title instead:

```php
OverlookPlugin::make()
    ->alphabetical()
```

## Count formatting

Counts are abbreviated by default. Pass `false` for the full number, thousands-separated:

```php
OverlookPlugin::make()
    ->abbreviateCount(false)
```

Abbreviation rounds to whole units, so 1,200 renders as `1K` and 1,500 as `2K`. It is a glanceable summary rather than a precise figure — which is what the tooltip below is for. Turn abbreviation off on a dashboard where the exact number is the point.

### Tooltips

When a count is abbreviated, hovering the card reveals the exact figure. Turn that off with:

```php
OverlookPlugin::make()
    ->tooltips(false)
```

The tooltip only appears when there is something to reveal — the count must be abbreviated, and be 1,000 or more. A resource with 42 records shows no tooltip, because the card already shows the whole number.

## Excluding soft-deleted records

Trashed records are counted by default. `withoutTrashed()` leaves them out:

```php
OverlookPlugin::make()
    ->withoutTrashed()
```

This is applied only to models that actually use `SoftDeletes`, so it is safe to set panel-wide on a mix of models.

## Icons

Cards use each resource's navigation icon. `icons()` overrides that per resource. Note the direction — the **icon name is the key**, the resource class the value:

```php
use Awcodes\Overlook\OverlookPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            OverlookPlugin::make()
                ->icons([
                    'heroicon-o-heart' => \App\Filament\Resources\Shop\ProductResource::class,
                    'heroicon-o-newspaper' => \App\Filament\Resources\Shop\OrderResource::class,
                ]),
        ]);
}
```

Any resource not named here keeps its navigation icon. Because the icon name is the key, the same icon cannot be mapped to two resources in one array.

## Next steps

To change the count query or title for a single resource, see [Customizing resources](customizing-resources.md).
