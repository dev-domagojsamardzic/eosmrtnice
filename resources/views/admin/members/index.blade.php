<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-5">
            {{ __('admin.users') }}
        </h2>
    </x-slot>
    @livewire('members-table')
</x-app-layout>
