<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 mb-4 dark:text-gray-200">
            {{ __('admin.services') }}
        </h2>
    </x-slot>
    @livewire('tables.admin.services-table')
</x-app-layout>
