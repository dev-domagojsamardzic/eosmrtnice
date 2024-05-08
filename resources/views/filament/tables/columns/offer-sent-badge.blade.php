@php
    $class = $getRecord()->offer()->exists() ? 'success' : 'danger';
@endphp
<span style="--c-50:var(--{{$class}}-50);--c-400:var(--{{$class}}-400);--c-600:var(--{{$class}}-600);" class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-2 min-w-[theme(spacing.6)] py-1 fi-color-custom bg-custom-50 text-custom-600 ring-custom-600/10 dark:bg-custom-400/10 dark:text-custom-400 dark:ring-custom-400/30 fi-color-danger">
    <span class="grid">
        <span class="truncate">
                @if($getRecord()->offer()->exists())
                    {{ __('models/offer.sent') . ': ' . $getRecord()->offer->created_at->diffForHumans() }}
                @else
                    {{ __('models/offer.not_sent') }}
                @endif
        </span>
    </span>
</span>
