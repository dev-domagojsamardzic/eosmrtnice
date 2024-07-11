<?php

namespace App\Http\Livewire\Tables\User;

use App\Http\Livewire\Tables\PostsOffersTable as BaseTable;
use App\Models\PostsOffer;
use Exception;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class PostsOffersTable extends BaseTable
{
    protected function getQuery(): Builder
    {
        return PostsOffer::query()
            ->where('user_id', auth()->id())
            ->whereNotNull('sent_at')
            ->orderBy('created_at');
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
                Action::make('download_offer_pdf')
                    ->label(__('models/offer.download_pdf'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(PostsOffer $posts_offer) => route(auth_user_type() . '.posts-offers.download', ['posts_offer' => $posts_offer->id])),
            ])->iconPosition(IconPosition::Before),
        ];
    }
}
