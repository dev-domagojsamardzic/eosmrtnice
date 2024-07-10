<?php

namespace App\Http\Livewire\Tables\Partner;

use App\Http\Controllers\Partner\AdController;
use App\Models\Ad;
use App\Models\Company;
use App\Services\ImageService;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\View as ViewLayout;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\Tables\AdsTable as BaseAdsTable;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;


class AdsTable extends BaseAdsTable
{
    /**
     * Return query builder
     * @return Builder
     */
    protected function getQuery(): Builder
    {
        return Ad::query()
            ->where('expired', 0)
            ->whereHas('company', function (Builder $query) {
                $query->where('user_id', auth()->id());
            });
    }

    /**
     * Return table columns
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Split::make([
                ViewColumn::make('type')
                    ->view('filament.tables.columns.ad-type-icon')
                    ->label(__('models/ad.type')),
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
                Stack::make([
                    TextColumn::make('active')
                        ->badge()
                        ->formatStateUsing(fn () => __('common.is_active_m'))
                        ->color('secondary'),
                    ToggleColumn::make('active'),
                ])->grow(false)->alignStart()
            ])->from('md'),

            ViewLayout::make('partner.table.ads-table-collapsible-panel')
                ->collapsible(),
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
                EditAction::make('edit')
                    ->label(__('common.edit'))
                    ->icon('heroicon-s-pencil-square')
                    ->url(fn (Ad $ad): string => route(
                        auth_user_type() . '.ads.edit',
                        ['company' => $ad->company_id, 'ad' => $ad->id])),
                DeleteAction::make('delete')
                    ->label(__('common.delete'))
                    ->icon('heroicon-s-trash')
                    ->requiresConfirmation()
                    ->modalHeading(__('partner.delete_ad'))
                    ->modalDescription(__('admin.delete_ad_description'))
                    ->modalSubmitActionLabel(__('common.delete'))
                    ->action(fn (Ad $ad) => (new AdController(new ImageService()))->destroy($ad))
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
                                ->where('user_id', auth()->id())
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
