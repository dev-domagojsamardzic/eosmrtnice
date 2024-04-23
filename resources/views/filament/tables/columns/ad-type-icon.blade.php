@if($getRecord()->type->value === 1)
    <i class="fas fa-check-circle mt-1"></i>
@elseif($getRecord()->type->value === 2)
    <i class="fas fa-medal mt-1"></i>
@else
    <i class="fas fa-gem mt-1"></i>
@endif
<span class="ml-1">{{ ucfirst(strtolower($getRecord()->type->name)) }}</span>
