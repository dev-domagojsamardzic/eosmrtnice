<?php

namespace App\Http\Livewire\Tables;

use App\Models\PostsOffer;
use App\Models\User;
use Exception;
use Faker\Provider\Text;
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

class PostsOffersTable extends Component implements HasForms, HasTable
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
        return PostsOffer::query();
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
                        ->formatStateUsing(fn(PostsOffer $o):string => __('models/offer.valid_from').': ' . $o->valid_from->format('d.m.Y.') ),
                    TextColumn::make('valid_until')
                        ->label(__('models/offer.valid_until'))
                        ->formatStateUsing(fn(PostsOffer $o):string => __('models/offer.valid_until').': '.$o->valid_until->format('d.m.Y.')),
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
                        TextColumn::make('user.full_name')
                            ->searchable(['first_name', 'last_name']),
                        TextColumn::make('user.email'),
                    ]),
                    Stack::make([
                        TextColumn::make('post.deceased_full_name_lg')
                            ->searchable(),
                        TextColumn::make('post.type')
                            ->formatStateUsing(fn(PostsOffer $o): string => $o->post?->type->translate()),
                        TextColumn::make('post.size')
                            ->formatStateUsing(fn(PostsOffer $o): string => __('common.to').' '.$o->post?->size.' '.__('common.words')),
                        TextColumn::make('post.starts_at')
                            ->formatStateUsing(fn(PostsOffer $o): string => __('models/post.starts_at').': '.$o->post?->starts_at->format('d.m.Y.')),
                        TextColumn::make('post.image')
                            ->formatStateUsing(fn(PostsOffer $o): string => __('models/post.deceased_image').': '.($o->post?->image ? __('common.yes') : __('common.no')))
                            ->default(__('models/post.deceased_image').': '.__('common.no')),
                        TextColumn::make('post.is_framed')
                            ->formatStateUsing(fn(PostsOffer $o): string => __('models/post.is_framed').': '.($o->post?->is_framed ? __('common.yes') : __('common.no'))),
                        TextColumn::make('post.symbol')
                            ->formatStateUsing(fn(PostsOffer $o): string => __('models/post.symbol').': '.$o->post?->symbol->translate()),
                    ]),
                    Stack::make([
                        TextColumn::make('quantity')
                                ->formatStateUsing(fn (PostsOffer $o):string => __('models/offer.quantity') . ': ' . $o->quantity),
                        TextColumn::make('price')
                                ->formatStateUsing(fn (PostsOffer $o): string => __('models/offer.price') . ': ' . currency($o->price)),
                        TextColumn::make('total')
                            ->formatStateUsing(fn (PostsOffer $o): string => __('models/offer.total') . ': ' . currency($o->total)),
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
