# Overlook for Filament

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awcodes/overlook.svg?style=flat-square)](https://packagist.org/packages/awcodes/overlook)
[![Total Downloads](https://img.shields.io/packagist/dt/awcodes/overlook.svg?style=flat-square)](https://packagist.org/packages/awcodes/overlook)

A Filament plugin that adds an app overview widget to your admin panel.

![overlook-og](https://user-images.githubusercontent.com/3596800/225406836-83913580-5a1c-4ea9-96dc-2b5b2e00223f.png)

## Installation

You can install the package via composer:

```bash
composer require awcodes/overlook
```

Then add the widget to your dashboard class or the Filament config file.

```php
'widgets' => [
    'namespace' => 'App\\Filament\\Widgets',
    'path' => app_path('Filament/Widgets'),
    'register' => [
        \Awcodes\Overlook\Overlook::class,
        ...
    ],
],
```

## Configuration

By default, Overlook will display any resource registered with Filament, while still honoring the `canViewAny` policy. This can be undesired and also slow down the dashboard. To prevent this behavior publish the config file with:

```bash
php artisan vendor:publish --tag="overlook-config"
```

Inside the config you will have options to either "include" or "exclude" resources from being displayed. These are not meant to work together, you should use one of the other.

You can also choose to convert the count to a human-readable format. For example, 1000 will be converted to 1k. This is the default behavior. 

Converted counts will also have a tooltip that displays the full count. This can be disabled by setting `enable_convert_tooltip` to false.

```php
return [
    'includes' => [
        App\Filament\Resources\Blog\AuthorResource::class,
        App\Filament\Resources\Blog\CategoryResource::class,
        App\Filament\Resources\Blog\PostResource::class,
    ],
    'excludes' => [
//        App\Filament\Resources\Blog\AuthorResource::class,
    ],
    'should_convert_count' => true,
    'enable_convert_tooltip' => true,
];
```

## Reordering & Polling

Should you need to reorder the location of the widget or want to enable polling, you can make your own version of the Overlook widget and register it instead.

```php
namespace App\Filament\Widgets;

use Awcodes\Overlook\Overlook;

class CustomOverlookWidget extends Overlook
{
    protected static ?int $sort = 10;

    protected static ?string $pollingInterval = '10s';
}
```

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
