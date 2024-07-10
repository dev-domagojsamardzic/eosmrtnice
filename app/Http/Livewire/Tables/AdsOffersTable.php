<?php

namespace App\Http\Livewire\Tables;

use App\Models\AdsOffer;
use Exception;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class AdsOffersTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    /**
     * @param Table $table
     * @return Table
     * @throws Exception
     */
    public function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading(__('common.no_records'))
            ->emptyStateDescription('')
            ->striped()
            ->query($this->getQuery())
            ->columns($this->getColumns())
            ->filters($this->getFilters(), layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(4)
            ->filtersFormWidth(MaxWidth::FourExtraLarge)
            ->actions($this->getActions());
    }

    public function render(): View
    {
        return view('livewire.table');
    }

    protected function getQuery(): Builder
    {
        return AdsOffer::query();
    }

    /**
     * Get table columns
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Split::make([
                TextColumn::make('number')
                    ->label(__('models/offer.number'))
                    ->searchable()
                    ->weight(FontWeight::Bold),
                Stack::make([
                    TextColumn::make('valid_from')
                        ->label(__('models/offer.valid_from'))
                        ->formatStateUsing(fn(AdsOffer $o):string => __('models/offer.valid_from').': ' . $o->valid_from->format('d.m.Y.') ),
                    TextColumn::make('valid_until')
                        ->label(__('models/offer.valid_until'))
                        ->formatStateUsing(fn(AdsOffer $o):string => __('models/offer.valid_until').': '.$o->valid_until->format('d.m.Y.')),
                ]),
                ViewColumn::make('offer_sent')
                    ->view('filament.tables.columns.offer-sent-badge'),
                TextColumn::make('created_at')
                    ->label(__('models/offer.created_at'))
                    ->date('d.m.Y.')
            ])->from('md'),
            Panel::make([
                Tables\Columns\Layout\Grid::make([
                    'lg' => 3, 'sm' => 1,
                ])->schema([
                    Stack::make([
                        TextColumn::make('company.title')
                            ->label(__('models/offer.company'))
                            ->searchable(),
                        TextColumn::make('company.address')
                            ->label(__('models/company.address')),
                        TextColumn::make('company.town')
                            ->label(__('models/offer.town'))
                            ->formatStateUsing(fn(AdsOffer $o):string => $o->company->zipcode.', '.$o->company->town)
                            ->searchable(),
                        TextColumn::make('company.oib')
                            ->label(__('models/offer.oib')),
                    ]),
                    Stack::make([
                        TextColumn::make('ad.title')
                            ->formatStateUsing(fn (AdsOffer $o): string => __('models/ad.ad') . ': ' . $o->ad->title),
                        TextColumn::make('ad.type')
                            ->formatStateUsing(fn (AdsOffer $o): string => __('models/ad.type') . ': ' . $o->ad->type->translate()),
                        TextColumn::make('ad.months_valid')
                            ->formatStateUsing(fn (AdsOffer $o): string => __('models/ad.months_valid') . ': ' . $o->ad->months_valid),
                    ]),
                    Stack::make([
                        TextColumn::make('quantity')
                                ->formatStateUsing(fn (AdsOffer $o):string => __('models/offer.quantity') . ': ' . $o->quantity),
                        TextColumn::make('price')
                                ->formatStateUsing(fn (AdsOffer $o): string => __('models/offer.price') . ': ' . currency($o->price)),
                        TextColumn::make('total')
                            ->formatStateUsing(fn (AdsOffer $o): string => __('models/offer.total') . ': ' . currency($o->total)),
                    ]),
                ])

            ])->collapsible()->columnSpanFull(),
        ];
    }

    /**
     * Return table filters
     *
     * @throws Exception
     */
    protected function getFilters(): array
    {
        return [];
    }

    /**
     * Get table actions
     *
     * @return array
     */
    protected function getActions(): array
    {
        return [];
    }
}
