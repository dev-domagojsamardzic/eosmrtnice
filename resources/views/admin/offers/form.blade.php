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

            <div class="input-group date">
                <input id="datepicker" type="text" class="form-control" value="12-02-2012">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>

        </form>
        @push('scripts')
            <script type="module">
                document.addEventListener('DOMContentLoaded', function () {
                    $('#datepicker').datepicker();
                })
            </script>
        @endpush
    </div>
</x-app-layout>
