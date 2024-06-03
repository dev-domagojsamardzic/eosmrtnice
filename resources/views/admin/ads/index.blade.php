<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 mb-4 dark:text-gray-200">
            {{ __('models/ad.ads') }}
        </h2>
    </x-slot>
    @livewire('tables.admin.ads-table')
</x-app-layout>
