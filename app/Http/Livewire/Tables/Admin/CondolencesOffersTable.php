<?php

namespace App\Http\Livewire\Tables\Admin;

use App\Http\Controllers\Admin\CondolencesOfferController;
use App\Models\CondolencesOffer;
use Exception;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Layout\Grid;
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

class CondolencesOffersTable extends Component implements HasForms, HasTable
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
        return CondolencesOffer::query()->orderBy('created_at');
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
                        ->formatStateUsing(fn(CondolencesOffer $o):string => __('models/offer.valid_from').': ' . $o->valid_from->format('d.m.Y.') ),
                    TextColumn::make('valid_until')
                        ->label(__('models/offer.valid_until'))
                        ->formatStateUsing(fn(CondolencesOffer $o):string => __('models/offer.valid_until').': '.$o->valid_until->format('d.m.Y.')),
                ]),
                ViewColumn::make('offer_sent')
                    ->view('filament.tables.columns.offer-sent-badge'),
                TextColumn::make('created_at')
                    ->label(__('models/offer.created_at'))
                    ->date('d.m.Y.')
            ])->from('md'),
            Panel::make([
                Grid::make([
                    'lg' => 3, 'sm' => 1,
                ])->schema([
                    Stack::make([
                        TextColumn::make('condolence.sender_full_name')
                            ->searchable(),
                        TextColumn::make('condolence.sender_email')
                            ->searchable(),
                        TextColumn::make('condolence.sender_phone')
                            ->searchable(),
                        TextColumn::make('condolence.sender_address')
                            ->searchable(),
                        TextColumn::make('condolence.sender_additional_info')
                            ->searchable(),
                    ]),
                    Stack::make([
                        TextColumn::make('motive')
                            ->formatStateUsing(fn(CondolencesOffer $c) => $c->condolence?->motive->translate()),
                        TextColumn::make('package_addons')
                            ->formatStateUsing(fn(CondolencesOffer $c) => implode(',',$c->condolence?->addons)),
                        TextColumn::make('message'),
                    ]),
                    Stack::make([
                        TextColumn::make('quantity')
                            ->formatStateUsing(fn (CondolencesOffer $o):string => __('models/offer.quantity') . ': ' . $o->quantity),
                        TextColumn::make('price')
                            ->formatStateUsing(fn (CondolencesOffer $o): string => __('models/offer.price') . ': ' . currency($o->price)),
                        TextColumn::make('total')
                            ->formatStateUsing(fn (CondolencesOffer $o): string => __('models/offer.total') . ': ' . currency($o->total)),
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
    protected function getActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('send_offer')
                    ->label(__('models/offer.send'))
                    ->icon('heroicon-o-paper-airplane')
                    ->visible(fn(CondolencesOffer $co): bool => is_null($co->sent_at))
                    ->url(fn(CondolencesOffer $co): string => route(auth_user_type() . '.condolences-offers.send', ['condolences_offer' => $co->id])),
                Action::make('download_offer_pdf')
                    ->label(__('models/offer.download_pdf'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(CondolencesOffer $co) => route(auth_user_type() . '.condolences-offers.download', ['condolences_offer' => $co->id])),
                EditAction::make('edit')
                    ->label(__('common.edit'))
                    ->icon('heroicon-s-pencil-square')
                    ->url(fn(CondolencesOffer $co) => route(auth_user_type() . '.condolences-offers.edit', $co)),
                DeleteAction::make('delete')
                    ->label(__('common.delete'))
                    ->icon('heroicon-s-trash')
                    ->requiresConfirmation()
                    ->modalHeading(__(auth_user_type() . '.delete_offer'))
                    ->modalSubmitActionLabel(__('common.delete'))
                    ->action(fn (CondolencesOffer $co): RedirectResponse|Redirector => (new CondolencesOfferController())->destroy($co))
            ])->iconPosition(IconPosition::Before),
        ];
    }
}
