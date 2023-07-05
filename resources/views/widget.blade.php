<x-filament-widgets::widget id="overlook-widget" @class(['hidden' => ! $data])>
    <div
        @if ($this->shouldLoadCss())
            x-data="{}"
            x-load-css="['{{ asset('css/awcodes/overlook/overlook.css') }}']"
        @endif
    >
        @if($data)
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
                        <div
                            class="rounded-xl ring-1 ring-gray-950/5 relative h-24 bg-gradient-to-tr from-gray-100 via-white to-white dark:ring-white/20 dark:from-gray-900 dark:via-gray-800 dark:to-gray-800"
                            wire:key="{{ $resource['name'] }}"
                            @if ($this->shouldShowTooltips($resource['raw_count']))
                                x-data x-tooltip="'{{ $resource['raw_count'] }}'"
                            @endif
                        >
                            <a href="{{ $resource['url'] }}" class="overflow-hidden absolute inset-0 py-2 px-3 text-gray-600 font-medium rounded-xl ring-primary-500 dark:text-gray-400 group hover:ring-2 focus:ring-2">
                                @if ($resource['icon'])
                                    <x-filament::icon
                                        :name="$resource['icon']"
                                        :size="24"
                                        class="w-auto h-24 absolute left-0 top-8 text-primary-500 opacity-20 dark:opacity-20 transition group-hover:scale-110 group-hover:-rotate-12 group-hover:opacity-40 dark:group-hover:opacity-80"
                                    />
                                @endif
                                {{ $resource['name'] }}
                                <span class="text-gray-600 dark:text-gray-300 absolute leading-none bottom-3 right-4 text-3xl font-bold">{{ $resource['count'] }}</span>
                            </a>
                        </div>
                    </x-filament::grid.column>
                @endforeach
            </x-filament::grid>
        @else
            <div class="-my-8"></div>
        @endif
    </div>
</x-filament-widgets::widget>