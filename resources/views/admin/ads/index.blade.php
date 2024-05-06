<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-5">
            {{ __('models/ad.ads') }}
        </h2>
    </x-slot>
    @livewire('tables.admin.ads-table')
</x-app-layout>
