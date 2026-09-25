<?php

declare(strict_types=1);

use Awcodes\Focus\Enums\Viewport;
use Awcodes\Focus\Screenshot;
use Awcodes\Focus\ScreenshotSuite;
use Playwright\Page\PageInterface;

/*
 * Documentation screenshots for Overlook, generated with awcodes/focus from the
 * Workbench (run `composer build` first). The widget shows the seeded record
 * counts with the plugin's default configuration.
 */

return ScreenshotSuite::make()
    ->screenshots([
        Screenshot::make('dashboard')
            // The dashboard holds only the widget; a full-height viewport is mostly empty page.
            ->viewportSize(1440, 420)
            ->visit('/admin')
            // Filament's default avatar is lazy-loaded from ui-avatars.com, which Focus's
            // readiness check does not wait for and which needs the network. Hidden, not
            // removed, so the top bar keeps its layout.
            ->beforeCapture(fn (PageInterface $page): PageInterface => $page->addStyleTag([
                'content' => '.fi-user-avatar { visibility: hidden !important; }',
            ]))
            ->viewport(),

        Screenshot::make('widget')
            ->visit('/admin')
            ->focus('#overlook-widget'),

        Screenshot::make('widget-mobile')
            ->viewportSize(Viewport::Mobile)
            ->visit('/admin')
            ->focus('#overlook-widget'),
    ]);
