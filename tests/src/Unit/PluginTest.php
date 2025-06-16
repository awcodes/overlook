<?php

declare(strict_types=1);

use Awcodes\Overlook\OverlookPlugin;
use Awcodes\Overlook\Tests\Fixtures\Resources\Users\UserResource;
use Awcodes\Overlook\Widgets\OverlookWidget;
use Filament\Facades\Filament;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

it('can register the plugin', function () {
    $this->panel
        ->plugins([
            OverlookPlugin::make(),
        ]);

    expect(Filament::getPlugin('awcodes/overlook'))->toBeInstanceOf(OverlookPlugin::class);
});

it('can register the widget', function () {
    $this->panel
        ->plugins([
            OverlookPlugin::make(),
        ])
        ->widgets([
            OverlookWidget::class,
        ]);

    expect(Filament::getWidgets())->toContain('Awcodes\Overlook\Widgets\OverlookWidget');
});

it('sets alphabetical order', function (bool|Closure|null $condition) {
    $this->panel
        ->plugins([
            OverlookPlugin::make()->alphabetical($condition),
        ]);

    expect(Filament::getPlugin('awcodes/overlook')->shouldSortAlphabetical())
        ->toBe($condition);
})->with([
    true,
    fn () => true,
    false,
    fn () => false,
]);

it('sets abbreviated', function (bool|Closure|null $condition) {
    $this->panel
        ->plugins([
            OverlookPlugin::make()->abbreviateCount($condition),
        ]);

    expect(Filament::getPlugin('awcodes/overlook')->shouldAbbreviateCount())
        ->toBe($condition);
})->with([
    true,
    fn () => true,
    false,
    fn () => false,
]);

it('sets sort order', function (int|Closure $condition) {
    $this->panel
        ->plugins([
            OverlookPlugin::make()->sort($condition),
        ]);

    expect(Filament::getPlugin('awcodes/overlook')->getSort())
        ->toBeInt()
        ->toBe(1);
})->with([
    1,
    fn () => 1,
]);

it('sets tooltips', function (bool|Closure|null $condition) {
    $this->panel
        ->plugins([
            OverlookPlugin::make()->tooltips($condition),
        ]);

    expect(Filament::getPlugin('awcodes/overlook')->shouldShowTooltips())
        ->toBe($condition);
})->with([
    true,
    fn () => true,
    false,
    fn () => false,
]);

it('sets icons', function () {
    $this->panel
        ->plugins([
            OverlookPlugin::make()->icons([
                'heroicon-o-heart' => 'App\Filament\Resources\Shop\ProductResource',
                'heroicon-o-newspaper' => 'App\Filament\Resources\Shop\OrderResource',
            ]),
        ]);

    expect(Filament::getPlugin('awcodes/overlook')->getIcons())
        ->toBe([
            'heroicon-o-heart' => 'App\Filament\Resources\Shop\ProductResource',
            'heroicon-o-newspaper' => 'App\Filament\Resources\Shop\OrderResource',
        ]);
});

it('sets icons with closure', function () {
    $this->panel
        ->plugins([
            OverlookPlugin::make()->icons(fn () => [
                'heroicon-o-heart' => 'App\Filament\Resources\Shop\ProductResource',
                'heroicon-o-newspaper' => 'App\Filament\Resources\Shop\OrderResource',
            ]),
        ]);

    expect(Filament::getPlugin('awcodes/overlook')->getIcons())
        ->toBe([
            'heroicon-o-heart' => 'App\Filament\Resources\Shop\ProductResource',
            'heroicon-o-newspaper' => 'App\Filament\Resources\Shop\OrderResource',
        ]);
});

it('sets excludes', function () {
    $this->panel
        ->plugins([
            OverlookPlugin::make()->excludes([
                UserResource::class,
            ]),
        ]);

    expect(Filament::getPlugin('awcodes/overlook')->getExcludes())
        ->toContain('Awcodes\Overlook\Tests\Fixtures\Resources\Users\UserResource');
});

it('sets excludes with closure', function () {
    $this->panel
        ->plugins([
            OverlookPlugin::make()->excludes(fn () => [
                UserResource::class,
            ]),
        ]);

    expect(Filament::getPlugin('awcodes/overlook')->getExcludes())
        ->toContain('Awcodes\Overlook\Tests\Fixtures\Resources\Users\UserResource');
});

it('sets includes', function () {
    $this->panel
        ->plugins([
            OverlookPlugin::make()->includes([
                UserResource::class,
            ]),
        ]);

    expect(Filament::getPlugin('awcodes/overlook')->getIncludes())
        ->toContain('Awcodes\Overlook\Tests\Fixtures\Resources\Users\UserResource');
});

it('sets includes with closure', function () {
    $this->panel
        ->plugins([
            OverlookPlugin::make()->includes(fn () => [
                UserResource::class,
            ]),
        ]);

    expect(Filament::getPlugin('awcodes/overlook')->getIncludes())
        ->toContain('Awcodes\Overlook\Tests\Fixtures\Resources\Users\UserResource');
});
