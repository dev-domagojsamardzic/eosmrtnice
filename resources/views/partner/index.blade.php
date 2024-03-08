<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-4">
            {{ __('admin.partners') }}
        </h2>
    </x-slot>
    @livewire('partners-table')
</x-app-layout>
