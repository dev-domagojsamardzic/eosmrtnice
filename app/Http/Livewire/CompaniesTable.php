<?php

namespace App\Http\Livewire;

use App\Models\Company;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
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
                TextColumn::make('title')
                    ->label(__('admin.company_title'))
                    ->sortable()
                    ->searchable()
                    ->weight(FontWeight::Bold),
                TextColumn::make('user.full_name')
                    ->label(__('admin.company_representative'))
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('email')
                    ->label(__('admin.email'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->formatStateUsing(fn (Carbon $date): string => $date->format('d.m.Y.'))
                    ->label(__('admin.company_created_at'))
                    ->sortable(),
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
            ]),
            Panel::make([
                Stack::make([
                    TextColumn::make('address')
                        ->label(__('admin.address')),
                    TextColumn::make('town')
                        ->label(__('admin.town')),
                    TextColumn::make('zipcode')
                        ->label(__('admin.zipcode')),
                    TextColumn::make('oib')
                        ->label(__('admin.oib')),
                    TextColumn::make('email')
                        ->icon('heroicon-m-envelope'),
                    TextColumn::make('phone')
                        ->icon('heroicon-m-phone'),
                    TextColumn::make('mobile_phone')
                        ->icon('heroicon-m-device-phone-mobile'),
                ])->space(2),
            ])->collapsible(),
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
                ])
            ->default(1),
        ];
    }

    /**
     * Return table actions
     * @return array
     */
    private function getActions(): array
    {
        return [
            Action::make('edit')
                ->label(__('common.edit'))
                ->icon('heroicon-s-pencil-square')
                ->iconButton()
                ->url(fn (Company $company): string => route(auth_user_type() . '.companies.edit', $company)),
            Action::make('delete')
                ->label(__('common.delete'))
                ->icon('heroicon-s-trash')
                ->iconButton()
                ->requiresConfirmation()
                ->action(fn (Company $company) => $company->delete())
        ];
    }
}
