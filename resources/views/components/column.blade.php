@props([
    'default' => 1,
    'sm' => null,
    'md' => null,
    'lg' => null,
    'xl' => null,
    'twoXl' => null,
    'defaultStart' => null,
    'smStart' => null,
    'mdStart' => null,
    'lgStart' => null,
    'xlStart' => null,
    'twoXlStart' => null,
    'hidden' => false,
])

@php
    $getSpanValue = function ($span): string {
        if ($span === 'full') {
            return '1 / -1';
        }

        return "span {$span} / span {$span}";
    };
@endphp

<div
        {{
            $attributes
                ->class([
                    'hidden' => $hidden || $default === 'hidden',
                    'col-[var(--col-span-default)]' => $default && (! $hidden),
                    'sm:col-[var(--col-span-sm)]' => $sm && (! $hidden),
                    'md:col-[var(--col-span-md)]' => $md && (! $hidden),
                    'lg:col-[var(--col-span-lg)]' => $lg && (! $hidden),
                    'xl:col-[var(--col-span-xl)]' => $xl && (! $hidden),
                    '2xl:col-[var(--col-span-2xl)]' => $twoXl && (! $hidden),
                    'col-start-[var(--col-start-default)]' => $defaultStart && (! $hidden),
                    'sm:col-start-[var(--col-start-sm)]' => $smStart && (! $hidden),
                    'md:col-start-[var(--col-start-md)]' => $mdStart && (! $hidden),
                    'lg:col-start-[var(--col-start-lg)]' => $lgStart && (! $hidden),
                    'xl:col-start-[var(--col-start-xl)]' => $xlStart && (! $hidden),
                    '2xl:col-start-[var(--col-start-2xl)]' => $twoXlStart && (! $hidden),
                ])
                ->style([
                    "--col-span-default: {$getSpanValue($default)}" => $default,
                    "--col-span-sm: {$getSpanValue($sm)}" => $sm,
                    "--col-span-md: {$getSpanValue($md)}" => $md,
                    "--col-span-lg: {$getSpanValue($lg)}" => $lg,
                    "--col-span-xl: {$getSpanValue($xl)}" => $xl,
                    "--col-span-2xl: {$getSpanValue($twoXl)}" => $twoXl,
                    "--col-start-default: {$defaultStart}" => $defaultStart,
                    "--col-start-sm: {$smStart}" => $smStart,
                    "--col-start-md: {$mdStart}" => $mdStart,
                    "--col-start-lg: {$lgStart}" => $lgStart,
                    "--col-start-xl: {$xlStart}" => $xlStart,
                    "--col-start-2xl: {$twoXlStart}" => $twoXlStart,
                ])
        }}
>
    {{ $slot }}
</div>