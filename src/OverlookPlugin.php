<?php

namespace Awcodes\Overlook;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Concerns\HasColumns;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

class OverlookPlugin implements Plugin
{
    use EvaluatesClosures;
    use HasColumns;

    protected array | Closure | null $excludes = null;

    protected array | Closure | null $includes = null;

    protected bool | Closure | null $shouldAbbreviateCount = null;

    protected bool | Closure | null $shouldShowTooltips = null;

    protected int | Closure | null $shouldSortAlphabetical = null;

    protected int | Closure | null $sort = null;

    protected array | Closure | null $icons = null;

    public function getId(): string
    {
        return 'awcodes/overlook';
    }

    public function register(Panel $panel): void
    {
    }

    public function boot(Panel $panel): void
    {
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        return filament(app(static::class)->getId());
    }

    public function alphabetical(bool | Closure | null $condition = true): static
    {
        $this->shouldSortAlphabetical = $condition;

        return $this;
    }

    public function abbreviateCount(bool | Closure | null $condition = true): static
    {
        $this->shouldAbbreviateCount = $condition;

        return $this;
    }

    public function excludes(array | Closure $resources): static
    {
        $this->excludes = $resources;

        return $this;
    }

    public function getColumnsConfig(): array
    {
        if ($this instanceof ComponentContainer && $this->getParentComponent()) {
            return $this->getParentComponent()->getColumnsConfig();
        }

        return $this->columns ?? [
            'default' => 2,
            'sm' => 2,
            'md' => 3,
            'lg' => 4,
            'xl' => 5,
            '2xl' => null,
        ];
    }

    public function getExcludes(): array
    {
        return $this->evaluate($this->excludes) ?? [];
    }

    public function getIncludes(): array
    {
        return $this->evaluate($this->includes) ?? [];
    }

    public function getSort(): int
    {
        return $this->evaluate($this->sort) ?? -1;
    }

    public function includes(array | Closure $resources): static
    {
        $this->includes = $resources;

        return $this;
    }

    public function shouldAbbreviateCount(): bool
    {
        return $this->evaluate($this->shouldAbbreviateCount) ?? true;
    }

    public function shouldShowTooltips(): bool
    {
        return $this->evaluate($this->shouldShowTooltips) ?? true;
    }

    public function shouldSortAlphabetical(): bool
    {
        return $this->evaluate($this->shouldSortAlphabetical) ?? false;
    }

    public function sort(int | Closure $sort): static
    {
        $this->sort = $sort;

        return $this;
    }

    public function tooltips(bool | Closure | null $condition = true): static
    {
        $this->shouldShowTooltips = $condition;

        return $this;
    }

    public function icons(array | Closure | null $icons): static
    {
        $this->icons = $icons;

        return $this;
    }

    public function getIcons(): array
    {
        return $this->evaluate($this->icons) ?? [];
    }
}
