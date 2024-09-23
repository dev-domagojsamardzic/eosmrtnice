<x-guest-layout>
    <div class="my-5 d-flex align-items-center justify-content-center flex-column">
        <h1>{{ __('thankyou.order_successfuly_recieved') }}</h1>
        <h3 class="mt-2">{{ __('thankyou.we_will_contact_you_soon') }}</h3>
        <a type="button" class="btn btn-primary mt-5" href="{{ route('homepage') }}">{{ __('common.homepage') }}</a>
    </div>
</x-guest-layout>
