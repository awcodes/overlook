---
title: Installation
description: Install Overlook, register the plugin and widget with a panel, and add its views to your theme.
---

# Installation

## Requirements

- PHP 8.2 or higher
- Filament 4.x or 5.x

Earlier releases of this package support earlier versions of Filament:

| Package Version | Filament Version |
| --- | --- |
| 1.x | 2.x |
| 2.x | 3.x |
| 3.x | 4.x |
| 4.x | 4.x & 5.x |

## Install the package

Install with Composer:

```bash
composer require awcodes/overlook
```

The service provider is registered automatically, and there is no configuration file to publish.

## Register the plugin and widget

Overlook needs **both** halves registered on the panel — the plugin, which holds the settings, and the widget, which does the rendering:

```php
use Awcodes\Overlook\OverlookPlugin;
use Awcodes\Overlook\Widgets\OverlookWidget;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            OverlookPlugin::make(),
        ])
        ->widgets([
            OverlookWidget::class,
        ]);
}
```

> [!IMPORTANT]
> The widget reads its settings from the plugin at render time. Registering the widget without the plugin will fail when it looks the plugin up, so both lines are required even if you change none of the defaults.

The widget spans the full width of the dashboard.

## Register the views with Tailwind

The widget is rendered from Blade views in the package, so your Tailwind build has to be able to see them. Add the package as a source in your theme's CSS file:

```css
@source '../../../../vendor/awcodes/overlook/resources/**/*.blade.php';
```

> [!NOTE]
> This step needs a custom theme. If you have not created one yet, follow [Creating a custom theme](https://filamentphp.com/docs/4.x/styling/overview#creating-a-custom-theme) in the Filament documentation first.

The relative path above assumes the conventional theme location, `resources/css/filament/<panel>/theme.css`. Adjust the number of `../` segments if your theme lives elsewhere — the path has to resolve to `vendor/awcodes/overlook/resources` from the file it is written in.

Without this step the cards still render, but with none of their layout or styling.

## Next steps

The widget works as-is. See [Configuration](configuration.md) to change the layout, ordering, or which resources appear.
