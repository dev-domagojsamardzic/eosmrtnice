<?php

namespace App\Http\Livewire\Tables\Admin;

use App\Models\Ad;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\View as ViewLayout;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class AdsTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->striped()
            ->query($this->getQuery())
            ->emptyStateHeading(__('common.no_records'))
            ->emptyStateDescription('')
            ->columns($this->getColumns())
            ->filters($this->getFilters())
            ->actions($this->getActions());
    }

    public function render(): View
    {
        return view('livewire.admin.ads-table');
    }

    private function getColumns(): array
    {
        return [
            Split::make([
                ImageColumn::make('logo')
                    ->circular()
                    ->defaultImageUrl(function(Ad $ad): string {
                        return $ad->company?->logo ?
                            public_storage_asset($ad->company->logo) :
                            asset($ad->company->alternative_logo);
                    })
                    ->tooltip(fn (Ad $ad): string => $ad->company?->type?->translate())
                    ->grow(false),
                TextColumn::make('company.title')
                    ->label(__('models/ad.company_id'))
                    ->sortable()
                    ->searchable(),
                ViewColumn::make('type')
                    ->view('filament.tables.columns.ad-type-icon')
                    ->label(__('models/ad.type')),
                TextColumn::make('approved')
                    ->label(__('models/ad.approved'))
                    ->badge()
                    ->formatStateUsing(fn(int $state): string => match($state) {
                        1 => __('common.approved'),
                        0 => __('common.not_approved'),
                    })
                    ->color(fn(int $state): string => match($state) {
                        1 => 'success',
                        0 => 'danger',
                    }),
                TextColumn::make('active')
                    ->label(__('models/ad.active'))
                    ->badge()
                    ->formatStateUsing(fn(int $state): string => match($state) {
                        1 => __('common.is_active_m'),
                        0 => __('common.is_inactive_m'),
                    })
                    ->color(fn(int $state): string => match($state) {
                        1 => 'success',
                        0 => 'danger',
                    }),
            ])->from('md'),

            ViewLayout::make('partner.table.ads-table-collapsible-panel')
                ->collapsible(),
        ];
    }

    /**
     * Return table filters
     * @return array
     */
    private function getFilters(): array
    {
        return [];
    }

    /**
     * Return table actions
     * @return array
     */
    private function getActions(): array
    {
        return  [
            Action::make('approve')
                ->label(fn (Ad $ad): string => $ad->approved ? __('common.disapprove') : __('common.approve'))
                ->button()
                ->action(function(Ad $ad): void {
                    $ad->approved = !$ad->approved;
                    $ad->save();
                })
                ->icon(fn (Ad $ad): string => $ad->approved ? 'heroicon-m-x-circle' : 'heroicon-m-check-circle')
                ->color(fn(Ad $ad): string => $ad->approved ? 'danger' : 'success')
                ->requiresConfirmation(),
            ActionGroup::make([
                EditAction::make('edit')
                    ->label(__('common.edit'))
                    ->icon('heroicon-s-pencil-square')
                    ->url(fn (Ad $ad): string => route(
                        auth_user_type() . '.ads.edit',
                        ['company' => $ad->company_id, 'ad' => $ad->id])),

            ])->iconPosition(IconPosition::Before),
        ];
    }

    /**
     * Return query builder
     * @return Builder
     */
    private function getQuery(): Builder
    {
        return Ad::query();
    }
}
