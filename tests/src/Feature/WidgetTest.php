<?php

declare(strict_types=1);

use Awcodes\Overlook\OverlookPlugin;
use Awcodes\Overlook\Tests\Fixtures\Models\User;
use Awcodes\Overlook\Tests\Fixtures\Resources\Users\CustomUserResource;
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
