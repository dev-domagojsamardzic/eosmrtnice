<?php

namespace App\Http\Livewire\Tables\Partner;

use App\Models\Ad;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Split;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\Layout\View as ViewLayout;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Filament\Forms\Components\Select;
use Livewire\Features\SupportRedirects\Redirector;


class AdsTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->striped()
            ->emptyStateHeading(__('common.no_records'))
            ->emptyStateDescription('')
            ->headerActions([
                Action::make('create_ad')
                    ->label(__('models/ad.new_ad'))
                    ->icon('heroicon-m-plus')
                    ->disabled(!auth()->user()->can('create', Ad::class ))
                    ->form([
                        Select::make('company_id')
                            ->label(__('models/ad.select_company_for_new_ad'))
                            ->options(auth()->user()->companies()->has('ad', '=', 0)->pluck('title', 'id'))
                            ->required(),
                    ])
                    ->action(function (array $data, Ad $ad): Redirector {
                        return redirect()->route(auth_user_type() . '.ads.create',$data['company_id']);
                    })
            ])
            ->query(Ad::query())
            ->columns($this->getColumns())
            ->filters($this->getFilters())
            ->actions($this->getActions());
    }

    public function render(): View
    {
        return view('livewire.ads-table');
    }

    /**
     * Return table columns
     * @return array
     */
    private function getColumns(): array
    {
        return [
            Split::make([
                TextColumn::make('company.title')
                    ->label(__('models/ad.company_id'))
                    ->sortable()
                    ->searchable()
                    ->weight(FontWeight::Bold),
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
            ])->from('md'),
            ViewLayout::make('partner.table.ads-table-collapsible-panel')
                ->collapsible(),
            /*Panel::make([
                TextColumn::make('months_valid')
                    ->label(__('models/ad.months_valid'))
                    ->formatStateUsing(fn (Ad $ad) => $ad->months_valid . ' ' .__('common.months')),
                TextColumn::make('valid_from')
                    ->label(__('models/ad.valid_from'))
                    ->formatStateUsing(fn (Carbon $date): string => $date->format('d.m.Y.')),
                TextColumn::make('valid_until')
                    ->label(__('models/ad.valid_until'))
                    ->formatStateUsing(fn (Carbon $date): string => $date->format('d.m.Y.'))
            ])->collapsible()->columnSpanFull(),*/
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
        return  [];
    }

    /**
     * Return table groups
     * @return array
     */
    private function getGroups(): array
    {
        return [];
    }


}
