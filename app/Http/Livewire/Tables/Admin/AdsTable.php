<?php

namespace App\Http\Livewire\Tables\Admin;

use App\Http\Controllers\Partner\AdController;
use App\Models\Ad;
use App\Models\Company;
use App\Services\ImageService;
use Exception;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\View as ViewLayout;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;
use App\Http\Livewire\Tables\AdsTable as BaseAdsTable;

class AdsTable extends BaseAdsTable
{
    /**
     * Return query builder
     * @return Builder
     */
    protected function getQuery(): Builder
    {
        return Ad::query()->orderByDesc('created_at');
    }

    protected function getColumns(): array
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
                ViewColumn::make('offer_sent')
                    ->view('filament.tables.columns.ad-offer-sent-badge'),
                TextColumn::make('expired')
                    ->label(__('models/ad.expired'))
                    ->badge()
                    ->formatStateUsing(fn(int $state): string => match($state) {
                        1 => __('models/ad.expired'),
                        default => ''
                    })
                    ->color(fn(int $state): string => match($state) {
                        1 => 'danger',
                        default => '',
                    }),
            ])->from('md'),

            ViewLayout::make('partner.table.ads-table-collapsible-panel')
                ->collapsible(),
        ];
    }

    /**
     * Return table filters
     * @return array
     * @throws Exception
     */
    protected function getFilters(): array
    {
        return [
            SelectFilter::make('expired')
                ->label(__('models/ad.actuality'))
                ->options([
                    0 => __('models/ad.ongoing_group'),
                    1 => __('models/ad.expired_group'),
                ])
        ];
    }

    /**
     * Return table actions
     * @return array
     */
    protected function getActions(): array
    {
        return  [
            ActionGroup::make([
                Action::make('create_offer')
                    ->label(__('models/offer.create'))
                    ->visible(fn(Ad $ad): bool => !$ad->offers()->valid()->exists())
                    ->icon('heroicon-s-plus')
                    ->color('black')
                    ->url(fn(Ad $ad): string => route('admin.ads-offers.create', ['ad' => $ad])),
                Action::make('download_offer_pdf')
                    ->label(__('models/ad.download_offer_pdf'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn(Ad $ad): bool => $ad->offers()->valid()->exists())
                    ->url(fn(Ad $ad) => route('admin.ads-offers.download', ['ads_offer' => $ad->offers()->valid()->first()->id])),
                Action::make('approve')
                    ->label(fn (Ad $ad): string => $ad->approved ? __('common.disapprove') : __('common.approve'))
                    ->action(function(Ad $ad): void {
                        $approved = !$ad->approved;
                        $ad->approved = !$ad->approved;
                        if ($approved) {
                            $ad->valid_from = now();
                            $ad->valid_until = now()->addMonths($ad->months_valid);
                        }
                        $ad->save();
                    })
                    ->icon(fn (Ad $ad): string => $ad->approved ? 'heroicon-m-x-circle' : 'heroicon-m-check-circle')
                    ->color(fn(Ad $ad): string => $ad->approved ? 'danger' : 'success')
                    ->requiresConfirmation(),
                EditAction::make('edit')
                    ->label(__('common.edit'))
                    ->icon('heroicon-s-pencil-square')
                    ->url(fn (Ad $ad): string => route(
                        auth_user_type() . '.ads.edit',
                        ['ad' => $ad->id])),
                DeleteAction::make('delete')
                    ->label(__('common.delete'))
                    ->icon('heroicon-s-trash')
                    ->requiresConfirmation()
                    ->modalHeading(__('admin.delete_ad'))
                    ->modalDescription(__('admin.delete_ad_description'))
                    ->modalSubmitActionLabel(__('common.delete'))
                    ->action(fn (Ad $ad) => (new AdController(new ImageService()))->destroy($ad)),

            ])->iconPosition(IconPosition::Before),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create_ad')
                ->label(__('models/ad.new_ad'))
                ->icon('heroicon-m-plus')
                ->form([
                    Select::make('company_id')
                        ->label(__('models/ad.select_company_for_new_ad'))
                        ->searchable()
                        ->options(
                            Company::query()
                                ->availableForAd()
                                ->get()
                                ->pluck('title', 'id')
                                ->toArray()
                        )
                        ->required(),
                ])
                ->action(function (array $data): RedirectResponse|Redirector {
                    return redirect()->route(auth_user_type() . '.ads.create',$data['company_id']);
                })
        ];
    }
}
