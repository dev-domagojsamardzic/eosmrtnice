<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 mb-4 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
            @livewire(App\Http\Livewire\Widgets\Admin\StatsOverview::class)
        </div>
    </div>
</x-app-layout>
