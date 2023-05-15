<x-filament::widget id="overlook-widget" @class(['hidden' => ! $data])>
    @if($data)
        <ul class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach($data as $resource)
                <li class="rounded-xl border border-gray-200 dark:border-gray-800 relative h-24 bg-gradient-to-tr from-gray-100 via-white to-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-800" wire:key="{{ $resource['name'] }}">
                    <a href="{{ $resource['url'] }}" class="overflow-hidden absolute inset-0 py-2 px-3 text-gray-600 font-medium rounded-xl ring-primary-500 dark:text-gray-400 group hover:ring-2 focus:ring-2">
                        @if ($resource['icon'])
                            <x-dynamic-component :component="$resource['icon']" class="w-auto h-24 absolute left-0 top-8 text-primary-500 opacity-20 dark:opacity-20 transition group-hover:scale-110 group-hover:-rotate-12 group-hover:opacity-40 dark:group-hover:opacity-80" />
                        @endif
                        {{ $resource['name'] }}
                        <span class="text-gray-600 dark:text-gray-300 absolute bottom-4 right-4 text-3xl font-bold">{{ $resource['count'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <div class="-my-8"></div>
    @endif
</x-filament::widget>

