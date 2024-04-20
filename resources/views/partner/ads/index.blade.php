<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-5">
            {{ __('models/ad.ads') }}
        </h2>
    </x-slot>
    @livewire('tables.partner.ads-table')
</x-app-layout>
