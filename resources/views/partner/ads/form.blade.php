<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-4">
            {{ __('models/ad.ads') }} - {{ __("common.{$action_name}") }}
        </h2>
    </x-slot>

    <div>
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($ad->exists)
                {{ method_field('PUT') }}
            @endif
        </form>
    </div>
</x-app-layout>
