<?php

declare(strict_types=1);

use Awcodes\Focus\Card;
use Awcodes\Focus\Enums\Size;
use Awcodes\Focus\Enums\Theme;
use Awcodes\Focus\Enums\Viewport;
use Awcodes\Focus\Screenshot;
use Awcodes\Focus\ScreenshotSuite;

/*
 * Documentation screenshots for Overlook, generated with awcodes/focus from the
 * Workbench (run `composer build` first). The widget shows the seeded record
 * counts with the plugin's default configuration.
 */

// The awcodes card templates frame each screenshot at 1400x816. Overlook's widget is small, so card screenshots
// are captured in that shape at a smaller size and the template scales them up: the widget fills more of the frame,
// and at scale 2 a half-size capture is still 1400x816 pixels.
$cardDashboard = [1050, 612];
$cardWidget = [700, 408];

return ScreenshotSuite::make()
    ->screenshots([
        Screenshot::make('dashboard')
            // The dashboard holds only the widget; a full-height viewport is mostly empty page.
            ->viewportSize(1440, 420)
            ->visit('/admin')
            ->viewport(),

        Screenshot::make('widget')
            ->visit('/admin')
            ->focus('#overlook-widget'),

        Screenshot::make('widget-mobile')
            ->viewportSize(Viewport::Mobile)
            ->visit('/admin')
            ->focus('#overlook-widget'),

        // Share-image sources, shaped to the card templates' screenshot slots. The two-up templates show slot 1
        // dark and slot 2 light, so the dashboard is captured dark and the widget in both themes.
        Screenshot::make('card-dashboard')
            ->viewportSize(...$cardDashboard)
            ->visit('/admin')
            ->viewport()
            ->themes([Theme::Dark]),

        Screenshot::make('card-widget')
            // A narrower page narrows the full-width widget, so its crop comes out close to the slot's shape.
            ->viewportSize(...$cardDashboard)
            ->visit('/admin')
            ->focus('#overlook-widget')
            ->minSize(...$cardWidget),
    ])
    ->cardTemplates('https://github.com/awcodes/focus-templates/tree/v1.1.0/dist')
    ->cards([
        // Open Graph and the GitHub social preview share one 2400x1260 template; GitHub crops 30px top and bottom.
        Card::make('social')
            ->template('two-up-wide')
            ->screenshots(['card-dashboard', 'card-widget'])
            ->sizes([Size::OpenGraph, Size::GitHubSocial]),

        // The Filament plugin directory's 2560x1440 thumbnail.
        Card::make('thumbnail')
            ->template('two-up')
            ->screenshots(['card-dashboard', 'card-widget'])
            ->sizes([Size::Filament]),
    ]);
