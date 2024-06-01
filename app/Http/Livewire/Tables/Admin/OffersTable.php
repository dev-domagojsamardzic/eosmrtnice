<?php

namespace App\Http\Livewire\Tables\Admin;

use App\Models\Offer;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Livewire\Component;

class OffersTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading(__('common.no_records'))
            ->emptyStateDescription('')
            ->striped()
            ->query(Offer::query()->orderBy('created_at'))
            ->columns($this->getColumns())
            ->filters([
                //
            ])
            ->actions([
                //
            ]);
    }

    public function render(): View
    {
        return view('livewire.offers-table');
    }

    private function getColumns(): array
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
                        ->formatStateUsing(fn(Carbon $validFrom):string => __('models/offer.valid_from').': '.$validFrom->format('d.m.Y.')),
                    TextColumn::make('valid_until')
                        ->label(__('models/offer.valid_until'))
                        ->formatStateUsing(fn(Carbon $validUntil):string => __('models/offer.valid_until').': '.$validUntil->format('d.m.Y.')),
                ]),
                ViewColumn::make('offer_sent')
                    ->view('filament.tables.columns.offer-sent-badge'),
                TextColumn::make('created_at')
                    ->label(__('models/offer.created_at'))
                    ->date('d.m.Y.')
            ])->from('md'),
            Panel::make([
                Tables\Columns\Layout\Grid::make([
                    'lg' => 2, 'sm' => 1,
                ])->schema([
                    Stack::make([
                        TextColumn::make('company.title')
                            ->label(__('models/offer.company'))
                            ->searchable(),
                        TextColumn::make('company.address')
                            ->label(__('models/company.address')),
                        TextColumn::make('company.town')
                            ->label(__('models/offer.town'))
                            ->formatStateUsing(fn(Offer $o):string => $o->company->zipcode.', '.$o->company->town)
                            ->searchable(),
                        TextColumn::make('company.oib')
                            ->label(__('models/offer.oib')),
                        TextColumn::make('company.owner.full_name')
                            ->label(__('models/offer.owner'))
                            ->searchable()
                    ]),
                    Stack::make([
                        TextColumn::make('offerables')
                            ->label(__('models/offer.items_count'))
                            ->formatStateUsing(fn(Offer $o): string => __('models/offer.items_count').': '.$o->offerables->count()),
                        TextColumn::make('taxes')
                            ->label(__('models/offer.company'))
                            ->formatStateUsing(fn(Offer $o): string => __('models/offer.taxes').': '.$o->taxes.config('app.currency_symbol')),
                        TextColumn::make('total')
                            ->label(__('models/offer.company'))
                            ->formatStateUsing(fn(Offer $o): string => __('models/offer.total').': '.$o->total.config('app.currency_symbol')),
                    ]),
                ])

            ])->collapsible()->columnSpanFull(),
        ];
    }
}
