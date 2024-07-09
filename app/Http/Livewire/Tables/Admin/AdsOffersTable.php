<?php

namespace App\Http\Livewire\Tables\Admin;

use App\Http\Controllers\Admin\OfferController;
use App\Models\AdsOffer;
use Exception;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

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

    private function getQuery(): Builder
    {
        return AdsOffer::query()->orderBy('created_at');
    }
    /**
     * Get table columns
     *
     * @return array
     */
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
                            ->formatStateUsing(fn(AdsOffer $o):string => $o->company->zipcode.', '.$o->company->town)
                            ->searchable(),
                        TextColumn::make('company.oib')
                            ->label(__('models/offer.oib')),
                    ]),
                    Stack::make([
                        TextColumn::make('taxes')
                            ->formatStateUsing(fn(AdsOffer $o): string => __('models/offer.taxes').': '.$o->taxes.config('app.currency_symbol')),
                        TextColumn::make('total')
                            ->formatStateUsing(fn(AdsOffer $o): string => __('models/offer.total').': '.$o->total.config('app.currency_symbol')),
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
    private function getFilters(): array
    {
        return [
            Filter::make('valid_from')
                ->form([
                    DatePicker::make('valid_from')
                        ->native(false)
                        ->label(__('models/offer.valid_from'))
                        ->format('Y-m-d')
                        ->displayFormat('d.m.Y.')
                        ->timezone('Europe/Zagreb'),
                ])
                ->indicateUsing(function (array $data): ?string {
                    if (! $data['valid_from']) {
                        return null;
                    }
                    return __('models/offer.valid_from').': '.Carbon::parse($data['valid_from'])->format('d.m.Y.');
                })
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['valid_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('valid_from', '>=', $date),
                        );
                }),
            Filter::make('valid_until')
                ->form([
                    DatePicker::make('valid_until')
                        ->native(false)
                        ->label(__('models/offer.valid_until'))
                        ->format('Y-m-d')
                        ->displayFormat('d.m.Y.')
                        ->timezone('Europe/Zagreb'),
                ])
                ->indicateUsing(function (array $data): ?string {
                    if (! $data['valid_until']) {
                        return null;
                    }
                    return __('models/offer.valid_until').': '.Carbon::parse($data['valid_until'])->format('d.m.Y.');
                })
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['valid_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('valid_until', '<=', $date),
                        );
                }),
            TernaryFilter::make('sent_at')
                ->label(__('models/offer.sent_at'))
                ->nullable()
                ->trueLabel(__('models/offer.sent_offers'))
                ->falseLabel(__('models/offer.not_sent_offers'))
        ];
    }

    /**
     * Get table actions
     *
     * @return array
     */
    private function getActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('send_offer')
                    ->label(__('models/offer.send'))
                    ->icon('heroicon-o-paper-airplane')
                    ->visible(fn(AdsOffer $offer): bool => is_null($offer->sent_at))
                    ->url(fn(AdsOffer $offer): string => route('admin.ads-offers.send', ['ads_offer' => $offer->id])),
                Action::make('download_offer_pdf')
                    ->label(__('models/offer.download_pdf'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(AdsOffer $offer) => route('admin.ads-offers.download', ['ads_offer' => $offer->id])),
                EditAction::make('view')
                    ->label(__('common.edit'))
                    ->icon('heroicon-s-pencil-square')
                    ->url(fn(AdsOffer $offer) => route('admin.ads-offers.edit', $offer)),
                DeleteAction::make('delete')
                    ->label(__('common.delete'))
                    ->icon('heroicon-s-trash')
                    ->requiresConfirmation()
                    ->modalHeading(__('admin.delete_offer'))
                    ->modalSubmitActionLabel(__('common.delete'))
                    ->action(fn (AdsOffer $offer): RedirectResponse|Redirector => (new OfferController)->destroy($offer))
            ])->iconPosition(IconPosition::Before),
        ];
    }
}
