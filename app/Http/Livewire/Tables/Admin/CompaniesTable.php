<?php

namespace App\Http\Livewire\Tables\Admin;

use App\Models\Company;
use Exception;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\Tables\CompaniesTable as BaseCompaniesTable;

class CompaniesTable extends BaseCompaniesTable
{
    /**
     * @throws Exception
     */
    public function table(Table $table): Table
    {
        return parent::table($table)
            ->defaultGroup('type');
    }

    protected function getQuery(): Builder
    {
        return Company::query()
            ->with(['county', 'city', 'user'])
            ->orderBy('type')
            ->orderByDesc('active');
    }

    /**
     * Return table groups
     * @return array
     */
    protected function getGroups(): array
    {
        return [
            Group::make('type')
                ->label(__('admin.by_type'))
                ->titlePrefixedWithLabel(false)
                ->orderQueryUsing(fn (Builder $query) => $query->orderBy('type'))
                ->getTitleFromRecordUsing(fn (Company $company): string => $company->type->translate()),
            Group::make('active')
                ->label(__('common.is_active_f_pl'))
                ->titlePrefixedWithLabel(false)
                ->orderQueryUsing(fn (Builder $query) => $query->orderBy('active', 'desc'))
                ->getTitleFromRecordUsing(fn (Company $company): string => $company->active ? __('common.is_active_f_pl') : __('common.is_inactive_f_pl')),
        ];
    }
}
