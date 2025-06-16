@props([
    'isGrid' => true,
    'default' => 1,
    'direction' => 'row',
    'sm' => null,
    'md' => null,
    'lg' => null,
    'xl' => null,
    'twoXl' => null,
])

<div
        {{
            $attributes
                ->class([
                    'grid' => $isGrid && $direction === 'row',
                    'grid-cols-[var(--cols-default)]' => $default && ($direction === 'row'),
                    'columns-[var(--cols-default)]' => $default && ($direction === 'column'),
                    'sm:grid-cols-[var(--cols-sm)]' => $sm && ($direction === 'row'),
                    'sm:columns-[var(--cols-sm)]' => $sm && ($direction === 'column'),
                    'md:grid-cols-[var(--cols-md)]' => $md && ($direction === 'row'),
                    'md:columns-[var(--cols-md)]' => $md && ($direction === 'column'),
                    'lg:grid-cols-[var(--cols-lg)]' => $lg && ($direction === 'row'),
                    'lg:columns-[var(--cols-lg)]' => $lg && ($direction === 'column'),
                    'xl:grid-cols-[var(--cols-xl)]' => $xl && ($direction === 'row'),
                    'xl:columns-[var(--cols-xl)]' => $xl && ($direction === 'column'),
                    '2xl:grid-cols-[var(--cols-2xl)]' => $twoXl && ($direction === 'row'),
                    '2xl:columns-[var(--cols-2xl)]' => $twoXl && ($direction === 'column'),
                ])
                ->style(
                    match ($direction) {
                        'column' => [
                            "--cols-default: {$default}" => $default,
                            "--cols-sm: {$sm}" => $sm,
                            "--cols-md: {$md}" => $md,
                            "--cols-lg: {$lg}" => $lg,
                            "--cols-xl: {$xl}" => $xl,
                            "--cols-2xl: {$twoXl}" => $twoXl,
                        ],
                        'row' => [
                            "--cols-default: repeat({$default}, minmax(0, 1fr))" => $default,
                            "--cols-sm: repeat({$sm}, minmax(0, 1fr))" => $sm,
                            "--cols-md: repeat({$md}, minmax(0, 1fr))" => $md,
                            "--cols-lg: repeat({$lg}, minmax(0, 1fr))" => $lg,
                            "--cols-xl: repeat({$xl}, minmax(0, 1fr))" => $xl,
                            "--cols-2xl: repeat({$twoXl}, minmax(0, 1fr))" => $twoXl,
                        ],
                    },
                )
        }}
>
    {{ $slot }}
</div>