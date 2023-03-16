<?php

namespace Awcodes\Overlook;

use Composer\InstalledVersions;
use Filament\PluginServiceProvider;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;

class OverlookServiceProvider extends PluginServiceProvider
{
    public static string $name = 'overlook';

    public static string $viewNamespace = 'overlook';

    public static string $version = 'dev';

    public function configurePackage(Package $package): void
    {
        static::$version = InstalledVersions::getPrettyVersion('awcodes/overlook');

        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasViews(static::$viewNamespace);
    }

    protected function getStyles(): array
    {
        return [
            'plugin-overlook-' . static::$version =>  __DIR__ . '/../resources/dist/overlook.css'
        ];
    }

    public function packageBooted(): void
    {
        Livewire::component('overlook-widget', Overlook::class);
    }
}
