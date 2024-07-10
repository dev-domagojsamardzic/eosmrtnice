<?php

namespace App\Http\Livewire\Tables\Admin;

use App\Http\Controllers\Admin\PartnerController;
use App\Models\Partner;
use Carbon\Carbon;
use Exception;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class PartnersTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    /**
     * @throws Exception
     */
    public function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading(__('common.no_records'))
            ->emptyStateDescription('')
            ->striped()
            ->query(
                Partner::query()
            )
            ->groups($this->getGroups())
            ->defaultGroup('active')
            ->groupingSettingsHidden()
            ->actions($this->getActions())
            ->columns([
                Split::make($this->getColumns())->visibleFrom('md'),
                Stack::make($this->getColumns())->hiddenFrom('md')->space(3),
            ])
            ->filters($this->getFilters());
    }
    public function render(): View
    {
        return view('livewire.table');
    }

    /**
     * Return table columns
     * @return array
     */
    private function getColumns(): array
    {
        return [
            TextColumn::make('full_name')
                ->label(__('admin.full_name'))
                ->weight(FontWeight::Bold)
                ->sortable(['first_name','last_name'])
                ->searchable(['first_name','last_name']),
            TextColumn::make('active')
                ->label(__('admin.active'))
                ->badge()
                ->formatStateUsing(fn(int $state): string => match($state) {
                    1 => __('common.is_active_m'),
                    0 => __('common.is_inactive_m'),
                })
                ->color(fn(int $state): string => match($state) {
                    1 => 'success',
                    0 => 'danger',
                })
                ->sortable(),
            TextColumn::make('email')
                ->label(__('admin.email'))
                ->icon('heroicon-m-envelope')
                ->searchable()
                ->sortable(),
            TextColumn::make('created_at')
                ->label(__('admin.created'))
                ->icon('heroicon-m-clock')
                ->formatStateUsing(fn (Carbon $date): string => $date->format('d.m.Y.')),
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
                    1 => __('admin.active'),
                    0 => __('admin.inactive'),
                ]),
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
                    ->url(fn (Partner $partner): string => route(auth_user_type() . '.partners.edit', $partner)),
                DeleteAction::make('delete')
                    ->label(__('common.delete'))
                    ->requiresConfirmation()
                    ->modalHeading(__('admin.delete_partner'))
                    ->modalSubmitActionLabel(__('common.delete'))
                    ->action(function(Partner $partner) { (new PartnerController())->destroy($partner); })
            ]),
        ];
    }

    /**
     * Return table groups
     * @return array
     */
    private function getGroups(): array
    {
        return [
            Group::make('active')
                ->titlePrefixedWithLabel(false)
                ->orderQueryUsing(fn (Builder $query) => $query->orderBy('active', 'desc'))
                ->getTitleFromRecordUsing(fn (Partner $partner): string => $partner->active ? __('common.active_records') : __('common.inactive_records'))
        ];
    }
}
