<span class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-sm font-medium ring-1 ring-inset px-2 min-w-[theme(spacing.6)] py-1 fi-color-custom bg-custom-50 text-custom-600 ring-custom-600/10 dark:bg-custom-400/10 dark:text-custom-400 dark:ring-custom-400/30">
        @if($getRecord()->type->value === 1)
            <i class="fas fa-check-circle"></i>
        @elseif($getRecord()->type->value === 2)
            <i class="fas fa-medal"></i>
        @else
            <i class="fas fa-gem"></i>
        @endif
    <span class="ml-1">{{ ucfirst(strtolower($getRecord()->type->name)) }}</span>
</span>
