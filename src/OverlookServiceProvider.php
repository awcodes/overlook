<?php

namespace Awcodes\Overlook;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class OverlookServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('overlook')
            ->hasViews();
    }

    public function boot(): void
    {
        parent::boot();

        Livewire::component('overlook-widget', Widgets\OverlookWidget::class);

        if (app()->runningInConsole()) {
            FilamentAsset::register([
                Css::make('overlook', __DIR__ . '/../resources/dist/overlook.css')
            ], 'awcodes/overlook');
        }
    }
}
