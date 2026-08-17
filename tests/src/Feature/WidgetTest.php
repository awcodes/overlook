<?php

declare(strict_types=1);

use Awcodes\Overlook\OverlookPlugin;
use Awcodes\Overlook\Tests\Fixtures\Models\User;
use Awcodes\Overlook\Tests\Fixtures\Resources\Users\CustomUserResource;
use Awcodes\Overlook\Tests\Fixtures\Resources\Users\TitledUserResource;
use Awcodes\Overlook\Tests\Fixtures\Resources\Users\UserResource;
use Awcodes\Overlook\Widgets\OverlookWidget;
use Filament\Facades\Filament;

use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->panel = Filament::getCurrentOrDefaultPanel();
});

it('includes default resources', function () {
    $this->panel
        ->plugins([
            OverlookPlugin::make(),
        ])
        ->widgets([
            OverlookWidget::class,
        ]);

    livewire(OverlookWidget::class)
        ->assertSee('Users');
});

it('includes resources', function () {
    $this->panel
        ->plugins([
            OverlookPlugin::make()
                ->includes([
                    UserResource::class,
                ]),
        ])
        ->widgets([
            OverlookWidget::class,
        ]);

    livewire(OverlookWidget::class)
        ->assertSee('Users');
});

it('excludes resources', function () {
    $this->panel
        ->plugins([
            OverlookPlugin::make()
                ->excludes([
                    UserResource::class,
                ]),
        ])
        ->widgets([
            OverlookWidget::class,
        ]);

    livewire(OverlookWidget::class)
        ->assertDontSee('Users');
});

it('can be customized', function () {
    User::factory()->count(3)->create([
        'email_verified_at' => null,
    ]);

    $this->panel
        ->plugins([
            OverlookPlugin::make()
                ->includes([
                    CustomUserResource::class,
                ]),
        ])
        ->widgets([
            OverlookWidget::class,
        ]);

    livewire(OverlookWidget::class)
        ->assertSee('Unverified Users')
        ->assertViewHas('data', function ($data) {
            return $data[0]['count'] === '3'
                && $data[0]['name'] === 'Unverified Users';
        });
});

it('uses the $title property when one is set', function () {
    TitledUserResource::$title = 'Titled Users';

    $this->panel
        ->plugins([
            OverlookPlugin::make()
                ->includes([
                    TitledUserResource::class,
                ]),
        ])
        ->widgets([
            OverlookWidget::class,
        ]);

    livewire(OverlookWidget::class)
        ->assertSee('Titled Users');
});

it('falls back to the plural model label when no $title is set', function () {
    TitledUserResource::$title = null;

    $this->panel
        ->plugins([
            OverlookPlugin::make()
                ->includes([
                    TitledUserResource::class,
                ]),
        ])
        ->widgets([
            OverlookWidget::class,
        ]);

    livewire(OverlookWidget::class)
        ->assertSee('Users');
});

it('excludes soft deleted records when withoutTrashed is enabled', function () {
    // setUp creates 1 user for authentication
    User::factory()->count(3)->create();
    User::factory()->count(2)->create(['deleted_at' => now()]);

    $this->panel
        ->plugins([
            OverlookPlugin::make()
                ->withoutTrashed()
                ->includes([
                    UserResource::class,
                ]),
        ])
        ->widgets([
            OverlookWidget::class,
        ]);

    // 1 (from setUp) + 3 (created) = 4 non-trashed users
    livewire(OverlookWidget::class)
        ->assertViewHas('data', function ($data) {
            return $data[0]['count'] === '4';
        });
});

it('excludes soft deleted records by default due to SoftDeletes global scope', function () {
    // setUp creates 1 user for authentication
    User::factory()->count(3)->create();
    User::factory()->count(2)->create(['deleted_at' => now()]);

    $this->panel
        ->plugins([
            OverlookPlugin::make()
                ->includes([
                    UserResource::class,
                ]),
        ])
        ->widgets([
            OverlookWidget::class,
        ]);

    // Default SoftDeletes global scope excludes trashed: 1 (from setUp) + 3 = 4
    livewire(OverlookWidget::class)
        ->assertViewHas('data', function ($data) {
            return $data[0]['count'] === '4';
        });
});
