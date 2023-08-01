<x-filament-widgets::widget id="overlook-widget" @class(['hidden' => ! $data])>
    <x-filament::grid
        :default="$grid['default'] ?? 1"
        :sm="$grid['sm'] ?? null"
        :md="$grid['md'] ?? null"
        :lg="$grid['lg'] ?? null"
        :xl="$grid['xl'] ?? null"
        class="gap-6"
    >
        @foreach ($data as $resource)
            <x-filament::grid.column>
                <x-filament::section
                    class="overlook-card rounded-xl overflow-hidden relative h-24 bg-gradient-to-tr from-gray-100 via-white to-white dark:from-gray-950 dark:to-gray-900"
                >
                    <a
                        href="{{ $resource['url'] }}"
                        class="overlook-link absolute inset-0 py-2 px-3 text-gray-600 font-medium ring-primary-500 dark:text-gray-400 group hover:ring-2 focus:ring-2"
                        @if ($this->shouldShowTooltips($resource['raw_count']))
                            x-data x-tooltip="'{{ $resource['raw_count'] }}'"
                        @endif
                    >
                        @if ($resource['icon'])
                            <x-filament::icon
                                :icon="$resource['icon']"
                                :size="24"
                                class="overlook-icon w-auto h-24 absolute left-0 top-8 text-primary-500 opacity-20 dark:opacity-20 transition group-hover:scale-110 group-hover:-rotate-12 group-hover:opacity-40 dark:group-hover:opacity-80"
                            />
                        @endif
                        <span class="overlook-name">{{ $resource['name'] }}</span>
                        <span class="overlook-count text-gray-600 dark:text-gray-300 absolute leading-none bottom-3 right-4 text-3xl font-bold">{{ $resource['count'] }}</span>
                    </a>
                </x-filament::section>
            </x-filament::grid.column>
        @endforeach
    </x-filament::grid>
</x-filament-widgets::widget>