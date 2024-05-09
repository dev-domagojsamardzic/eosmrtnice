<x-app-layout>
    <x-slot name="header">
        <h2 class="font-weight-bolder mb-4">
            {{ __('models/offer.offer') }} - {{ __("common.{$action_name}") }}
        </h2>
        <h4 class="font-weight-bold">{{ $ad->type->name . ' - ' . $ad->company?->title }}</h4>
    </x-slot>

    <div>
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($offer->exists)
                {{ method_field('PUT') }}
            @endif

        </form>
    </div>
</x-app-layout>
