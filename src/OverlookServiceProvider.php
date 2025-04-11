<?php

declare(strict_types=1);

namespace Awcodes\Overlook;

use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class OverlookServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('overlook')
            ->hasViews();
    }

    public function packageBooted(): void
    {
        Livewire::component('overlook-widget', Widgets\OverlookWidget::class);
    }
}
