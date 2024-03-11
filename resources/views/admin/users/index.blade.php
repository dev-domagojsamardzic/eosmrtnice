<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-4">
            {{ __('admin.users') }}
        </h2>
    </x-slot>
    @livewire('users-table')
</x-app-layout>
