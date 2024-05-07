<?php

namespace App\Http\Livewire\Tables\Admin;

use App\Models\AppModelsService;
use App\Models\Service;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ServicesTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Service::query())
            ->columns($this->getColumns())
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.services-table');
    }

    /**
     * Return table columns
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            TextColumn::make('title')
                ->label(__('models/service.title'))
                ->weight(FontWeight::Bold),
            TextColumn::make('description')
                ->label(__('models/service.description')),
            TextColumn::make('price')
                ->label(__('models/service.price') . '/' . config('app.currency_symbol'))
                ->formatStateUsing(fn (float $state): string => number_format($state, 2) . ' ' . config('app.currency_symbol')),
        ];
    }
}
