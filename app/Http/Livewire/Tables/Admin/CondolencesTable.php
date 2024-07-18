<?php

namespace App\Http\Livewire\Tables\Admin;

use App\Models\Condolence;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class CondolencesTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->striped()
            ->emptyStateHeading(__('common.no_records'))
            ->emptyStateDescription('')
            ->query($this->getQuery())
            ->columns($this->getColumns())
            ->filters([])
            ->actions($this->getActions())
            ->headerActions($this->getHeaderActions());
    }

    public function render(): View
    {
        return view('livewire.table');
    }

    protected function getQuery(): Builder
    {
        return Condolence::query()->orderByDesc('created_at');
    }

    protected function getColumns(): array
    {
        return [
            Split::make([
                TextColumn::make('id')
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('recipient_full_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('paid_at')
                    ->badge()
                    ->formatStateUsing(function(Condolence $c) {
                        return ($c->paid_at) ? __('models/condolence.paid_at').': ' . $c->paid_at?->format('d.m.Y.') : __('common.not_paid');
                    })
                    ->color(fn(Condolence $c) => $c->paid_at ? 'success' : 'danger')
                    ->default(__('common.not_paid')),
                TextColumn::make('created_at')
                    ->date('d.m.Y.'),
            ])->from('md'),

            Panel::make([
                Grid::make([
                    'lg' => 3, 'sm' => 1,
                ])->schema([
                    Stack::make([
                        TextColumn::make('motive')
                            ->description(__('models/condolence.motive'))
                            ->formatStateUsing(fn(Condolence $c) => $c->motive->translate()),
                        TextColumn::make('package_addon')
                            ->description(__('models/condolence.package_addon'))
                            ->formatStateUsing(function(Condolence $c) {
                                return implode(',', $c->addons);
                            }),
                        TextColumn::make('message')
                            ->description(__('models/condolence.message'))
                            ->html()
                    ]),
                    Stack::make([
                        TextColumn::make('recipient_full_name')
                            ->searchable()
                            ->description(__('models/condolence.recipient_full_name')),
                        TextColumn::make('recipient_address')
                            ->searchable()
                            ->description(__('models/condolence.recipient_address')),
                    ]),
                    Stack::make([
                        TextColumn::make('sender_full_name')
                            ->searchable()
                            ->description(__('models/condolence.sender_full_name')),
                        TextColumn::make('sender_email')
                            ->searchable()
                            ->description(__('models/condolence.sender_email')),
                        TextColumn::make('sender_phone')
                            ->searchable()
                            ->description(__('models/condolence.sender_phone')),
                        TextColumn::make('sender_address')
                            ->searchable()
                            ->description(__('models/condolence.sender_address')),
                        TextColumn::make('sender_additional_info')
                            ->searchable()
                            ->description(__('models/condolence.sender_additional_info')),
                    ]),
                ])
            ])->collapsible()->columnSpanFull(),
        ];
    }

    protected function getActions(): array
    {
        return [
            ActionGroup::make([
                /*Action::make('create_offer')
                    ->label(__('models/offer.create'))
                    ->visible(true)
                    ->icon('heroicon-s-plus')
                    ->color('black')
                    ->url(fn(Condolence $c): string => route('admin.condolences-offers.create', ['condolence' => $c->id])),*/
                Action::make('edit')
                    ->label(__('common.edit'))
                    ->icon('heroicon-s-pencil-square')
                    ->url(fn(Condolence $c) => route('admin.condolences.edit', ['condolence' => $c->id])),
                Action::make('mark_paid')
                    ->label(fn (Condolence $c): string => $c->paid_at ? __('common.mark_unpaid') : __('common.mark_paid'))
                    ->action(function(Condolence $c): void {
                        $paidAt = ($c->paid_at) ? null : now();
                        $c->paid_at = $paidAt;
                        $c->save();
                    })
                    ->icon(fn (Condolence $c): string => $c->paid_at ? 'heroicon-m-x-circle' : 'heroicon-m-check-circle')
                    ->color(fn(Condolence $c): string => $c->paid_at ? 'danger' : 'success')
                    ->requiresConfirmation(),
            ])->dropdownPlacement('center')
            ->dropdownOffset(-200)
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
