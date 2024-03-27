<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-5">
            {{ __('admin.partners') }}
        </h2>
    </x-slot>
    @livewire('tables.partners-table')
</x-app-layout>
