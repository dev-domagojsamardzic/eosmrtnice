<?php

namespace App\Http\Livewire;

use App\Enums\CompanyType;
use App\Http\Controllers\CompanyController;
use App\Models\Company;
use App\Models\County;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\ActionGroup;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Exception;

class CompaniesTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    /**
     * @throws Exception
     */
    public function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading(__('common.empty'))
            ->striped()
            ->query(
                Company::query()
            )
            ->groups([
                Group::make('active')
                    ->titlePrefixedWithLabel(false)
                    ->orderQueryUsing(fn (Builder $query) => $query->orderBy('active', 'desc'))
                    ->getTitleFromRecordUsing(fn (Company $company): string => $company->active ? __('common.active_records') : __('common.inactive_records'))
            ])
            ->defaultGroup('active')
            ->groupingSettingsHidden()
            ->actions($this->getActions())
            ->columns($this->getColumns())
            ->filters($this->getFilters());
    }
    public function render(): View
    {
        return view('livewire.companies-table');
    }

    /**
     * Return table columns
     * @return array
     */
    private function getColumns(): array
    {
        return [
            Split::make([
                IconColumn::make('type')
                    ->icon(fn (Company $company): string => match($company->type) {
                        CompanyType::FUNERAL => 'coffin-outline',
                        CompanyType::MASONRY => 'tomb-outline',
                        CompanyType::FLOWERS => 'flowers-outline',
                        default => 'cross-outline',
                    })
                    ->tooltip(fn (Company $company): string => $company->type->translate())
                    ->grow(false),
                TextColumn::make('title')
                    ->label(__('admin.company_title'))
                    ->tooltip(__('admin.company_title'))
                    ->sortable()
                    ->searchable()
                    ->weight(FontWeight::Bold),
                TextColumn::make('active')
                    ->label(__('admin.active'))
                    ->badge()
                    ->formatStateUsing(fn(int $state): string => match($state) {
                        1 => __('admin.is_active'),
                        0 => __('admin.is_inactive'),
                    })
                    ->color(fn(int $state): string => match($state) {
                        1 => 'success',
                        0 => 'danger',
                    })
                    ->sortable(),
                TextColumn::make('user.full_name')
                    ->label(__('admin.company_representative'))
                    ->tooltip(__('admin.company_representative'))
                    ->icon('heroicon-m-user')
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('created_at')
                    ->label(__('admin.company_created_at'))
                    ->tooltip(__('admin.company_created_at'))
                    ->formatStateUsing(fn (Carbon $date): string => $date->format('d.m.Y.'))
                    ->icon('heroicon-m-clock')
                    ->sortable(),
            ])->from('md'),
            Panel::make([
                Stack::make([
                    TextColumn::make('address')
                        ->label(__('admin.address'))
                        ->icon('heroicon-m-home')
                        ->formatStateUsing(fn(Company $company): string => $company->address . ', ' . $company->zipcode . ' ' . $company->town),
                    TextColumn::make('county.title')
                        ->label(__('admin.county'))
                        ->icon('heroicon-m-map-pin'),
                    TextColumn::make('oib')
                        ->label(__('admin.oib'))
                        ->icon('heroicon-m-identification'),
                    TextColumn::make('email')
                        ->label(__('admin.email'))
                        ->icon('heroicon-m-envelope'),
                    TextColumn::make('phone')
                        ->label(__('admin.phone'))
                        ->icon('heroicon-m-phone'),
                    TextColumn::make('mobile_phone')
                        ->label(__('admin.mobile_phone'))
                        ->icon('heroicon-m-device-phone-mobile'),
                ])->space(3),
            ])->collapsible()->columnSpanFull(),
        ];
    }

    /**
     * Return table filters
     * @return array
     * @throws Exception
     */
    private function getFilters(): array
    {
        return [
            SelectFilter::make('active')
                ->label(__('admin.active'))
                ->options([
                    1 => __('admin.is_active'),
                    0 => __('admin.is_inactive'),
                ]),
            SelectFilter::make('county_id')
                ->label(__('admin.county'))
                ->options(County::query()->pluck('title', 'id')->toArray())
        ];
    }

    /**
     * Return table actions
     * @return array
     */
    private function getActions(): array
    {
        return [
            ActionGroup::make([
                EditAction::make('edit')
                    ->label(__('common.edit'))
                    ->icon('heroicon-s-pencil-square')
                    ->url(fn (Company $company): string => route(auth_user_type() . '.companies.edit', $company)),
                DeleteAction::make('delete')
                    ->label(__('common.delete'))
                    ->icon('heroicon-s-trash')
                    ->requiresConfirmation()
                    ->modalHeading(__('admin.delete_company'))
                    ->modalSubmitActionLabel(__('common.delete'))
                    ->action(function(Company $company) { (new CompanyController())->destroy($company); })
            ])->iconPosition(IconPosition::Before),
        ];
    }
}
