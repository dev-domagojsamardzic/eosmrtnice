<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-5">
            {{ __('admin.offers') }}
        </h2>
    </x-slot>
    @livewire('tables.admin.offers-table')
</x-app-layout>
