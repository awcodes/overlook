<?php

declare(strict_types=1);

namespace Awcodes\Overlook\Tests\Fixtures\Resources\Users;

use Awcodes\Overlook\Concerns\HandlesOverlookWidgetCustomization;
use Awcodes\Overlook\Contracts\CustomizeOverlookWidget;

/**
 * Uses the trait without overriding getOverlookWidgetTitle(), so the widget
 * title comes from the trait's $title property or its fallback.
 */
class TitledUserResource extends UserResource implements CustomizeOverlookWidget
{
    use HandlesOverlookWidgetCustomization;

    protected static ?string $slug = 'users';
}
