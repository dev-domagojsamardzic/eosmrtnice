<?php

namespace App\Http\Livewire\Tables\Admin;

use App\Http\Controllers\Admin\AdsOfferController;
use App\Models\AdsOffer;
use Exception;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Livewire\Features\SupportRedirects\Redirector;
use App\Http\Livewire\Tables\AdsOffersTable as BaseTable;

class AdsOffersTable extends BaseTable
{
    protected function getQuery(): Builder
    {
        return AdsOffer::query()->orderBy('created_at');
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
                    ->visible(fn(AdsOffer $ads_offer): bool => is_null($ads_offer->sent_at))
                    ->url(fn(AdsOffer $ads_offer): string => route(auth_user_type() . '.ads-offers.send', ['ads_offer' => $ads_offer->id])),
                Action::make('download_offer_pdf')
                    ->label(__('models/offer.download_pdf'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(AdsOffer $ads_offer) => route(auth_user_type() . '.ads-offers.download', ['ads_offer' => $ads_offer->id])),
                EditAction::make('view')
                    ->label(__('common.edit'))
                    ->icon('heroicon-s-pencil-square')
                    ->url(fn(AdsOffer $ads_offer) => route(auth_user_type() . '.ads-offers.edit', $ads_offer)),
                DeleteAction::make('delete')
                    ->label(__('common.delete'))
                    ->icon('heroicon-s-trash')
                    ->requiresConfirmation()
                    ->modalHeading(__(auth_user_type() . '.delete_offer'))
                    ->modalSubmitActionLabel(__('common.delete'))
                    ->action(fn (AdsOffer $ads_offer): RedirectResponse|Redirector => (new AdsOfferController())->destroy($ads_offer))
            ])->iconPosition(IconPosition::Before),
        ];
    }
}
