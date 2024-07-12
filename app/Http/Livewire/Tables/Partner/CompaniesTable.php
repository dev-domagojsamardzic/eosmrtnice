<?php

namespace App\Http\Livewire\Tables\Partner;

use App\Models\Company;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\Tables\CompaniesTable as BaseCompaniesTable;

class CompaniesTable extends BaseCompaniesTable
{
    protected function getQuery(): Builder
    {
        return Company::query()
            ->where('user_id', auth()->id())
            ->orderBy('active', 'desc');
    }

    /**
     * Return table groups
     * @return array
     */
    protected function getGroups(): array
    {
        return [
            Group::make('active')
                ->label(__('common.is_active_f_pl'))
                ->titlePrefixedWithLabel(false)
                ->orderQueryUsing(fn (Builder $query) => $query->orderBy('active', 'desc'))
                ->getTitleFromRecordUsing(fn (Company $company): string => $company->active ? __('common.is_active_f_pl') : __('common.is_inactive_f_pl')),
        ];
    }
}
