<?php

namespace App\Http\Livewire\Tables\Partner;

use App\Http\Controllers\Admin\OfferController;
use App\Models\Company;
use App\Models\Offer;
use Exception;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class OffersTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    /**
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
            ->filters($this->getFilters(), FiltersLayout::AboveContent)
            ->filtersFormColumns(4)
            ->filtersFormWidth(MaxWidth::FourExtraLarge)
            ->actions($this->getActions());
    }

    public function render(): View
    {
        return view('livewire.offers-table');
    }

    /**
     * Return query builder
     *
     * @return Builder
     */
    private function getQuery(): Builder
    {
        $companies = Company::query()->where('user_id', auth()->id())->pluck('id')->toArray();
        return Offer::query()->whereIn('company_id', $companies);
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
                        ->formatStateUsing(fn(Offer $o):string => __('models/offer.valid_from').': '.$o->valid_from->format('d.m.Y.')),
                    TextColumn::make('valid_until')
                        ->label(__('models/offer.valid_until'))
                        ->formatStateUsing(fn(Offer $o):string => __('models/offer.valid_until').': '.$o->valid_until->format('d.m.Y.')),
                ]),
                TextColumn::make('created_at')
                    ->label(__('models/offer.created_at'))
                    ->icon('heroicon-m-clock')
                    ->date('d.m.Y.')
            ])->from('md'),
            Panel::make([])->collapsible()->columnSpanFull(),
        ];
    }

    /**
     * Return table filters
     *
     * @throws Exception
     */
    private function getFilters(): array
    {
        return [];
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
                Action::make('download_offer_pdf')
                    ->label(__('models/offer.download_pdf'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(Offer $offer) => route('partner.offers.download', ['offer' => $offer->id])),
                ViewAction::make('view')
                    ->label(__('common.view'))
                    ->icon('heroicon-s-eye')
                    ->url(fn(Offer $offer) => route('partner.offers.show', $offer)),
            ])->iconPosition(IconPosition::Before),
        ];
    }
}
