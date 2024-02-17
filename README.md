# Overlook for Filament

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awcodes/overlook.svg?style=flat-square)](https://packagist.org/packages/awcodes/overlook)
[![Total Downloads](https://img.shields.io/packagist/dt/awcodes/overlook.svg?style=flat-square)](https://packagist.org/packages/awcodes/overlook)

![overlook-og](https://res.cloudinary.com/aw-codes/image/upload/w_1200,f_auto,q_auto/plugins/overlook/awcodes-overlook.jpg)

A Filament plugin that adds an app overview widget to your admin panel.

<!-- docs_start -->

## Installation

You can install the package via composer:

```bash
composer require awcodes/overlook
```

In an effort to align with Filament's theming methodology you will need to use a custom theme to use this plugin.

> **Note**
> If you have not set up a custom theme and are using a Panel follow the instructions in the [Filament Docs](https://filamentphp.com/docs/3.x/panels/themes#creating-a-custom-theme) first.

Add the plugin's views to your `tailwind.config.js` file.

```js
content: [
    '<path-to-vendor>/awcodes/overlook/resources/**/*.blade.php',
]
```

## Usage

Add the plugin and widget to your panel provider. You may use the `sort` and `columns` methods on the plugin to change the widget order and number of columns the widget will use to display its items.

```php
use Awcodes\Overlook\OverlookPlugin;
use Awcodes\Overlook\Widgets\OverlookWidget;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            OverlookPlugin::make()
                ->sort(2)
                ->columns([
                    'default' => 1,
                    'sm' => 2,
                    'md' => 3,
                    'lg' => 4,
                    'xl' => 5,
                    '2xl' => null,
                ]),
        ])
        ->widgets([
            OverlookWidget::class,
        ]);
}      
```

## Including and Excluding Items

By default, the widget will display all resources registered with Filament. You can use either the `includes` or `excludes` methods on the plugin to specify which resources to include or exclude.

***These methods should not be used together***

```php
use Awcodes\Overlook\OverlookPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            OverlookPlugin::make()
                ->includes([
                    \App\Filament\Resources\Shop\ProductResource::class,
                    \App\Filament\Resources\Shop\OrderResource::class,
                ]),
        ]);
}      
```

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

## Abbreviated Counts

You can disable abbreviated counts by passing `false` the `abbreviateCount` method on the plugin.

```php
use Awcodes\Overlook\OverlookPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            OverlookPlugin::make()
                ->abbreviateCount(false),
        ]);
}      
```

## Tooltips

When using abbreviated counts a tooltip will show on hover with the non abbreviated count. You can disable them by passing `false` the `tooltips` method on the plugin.

```php
use Awcodes\Overlook\OverlookPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            OverlookPlugin::make()
                ->tooltips(false),
        ]);
}
```

## Sorting the Items

By default, the items will be sorted in the order they are registered with Filament or as provided in the `includes` method. You can change this to sort them alphabetically with the `alphabetical` method on the plugin.

```php
use Awcodes\Overlook\OverlookPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            OverlookPlugin::make()
                ->alphabetical(),
        ]);
}      
```

## Customizing the Widget

By default, the overlook widget uses the `getEloquentQuery()` method of the Filament Resource, but you can customize the query by implementing the `CustomizeOverlookWidget` interface on the Filament Resource. The trait `HandlesOverlookWidgetCustomization` predefines existing customization that can be overriden on the resource class.

```php
use Awcodes\Overlook\Contracts\CustomizeOverlookWidget;
use Awcodes\Overlook\Concerns\HandlesOverlookWidgetCustomization;

class UserResource extends Resource implements CustomizeOverlookWidget
{
    use HandlesOverlookWidgetCustomization;
}
```

### Customize Widget Query

Override the `getOverlookWidgetQuery()` method to customize the query for the Overlook Widget. This method takes in the existing eloquent query as a parameter that can be used to make further customization.

```php
use Illuminate\Database\Eloquent\Builder;

public static function getOverlookWidgetQuery(Builder $query): Builder
{
    return $query->where('status','=','PENDING');
}
```

### Customize Widget Title

Override the `getOverlookWidgetTitle()` method to customize the title of the widget

```php
public static function getOverlookWidgetTitle(): string
{
    return 'Pending Users';
}
```

### Customize Widget Icon

By default, the icon will be loaded from the resource but you can override it by passing using the `icons` modifier on the plugin and passing it an array of icon names and resource names.

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


<!-- docs_end -->

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Adam Weston](https://github.com/awcodes)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
