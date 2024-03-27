<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-5">
            {{ __('admin.companies') }}
        </h2>
    </x-slot>
    @livewire('tables.admin.companies-table')
</x-app-layout>
