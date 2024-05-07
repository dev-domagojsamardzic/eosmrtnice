<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-5">
            {{ __('admin.services') }}
        </h2>
    </x-slot>
    @livewire('tables.admin.services-table')
</x-app-layout>
