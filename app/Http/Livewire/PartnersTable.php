<?php

namespace App\Http\Livewire;

use App\Enums\UserType;
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Exception;

class PartnersTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    /**
     * @throws Exception
     */
    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()->partners()
            )
            ->columns([
                TextColumn::make('full_name')
                    ->label(__('admin.full_name'))
                    ->sortable(['first_name','last_name'])
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('admin.email'))
                    ->searchable(),
                TextColumn::make('active')
                    ->label(__('admin.active'))
                    ->badge()
                    ->formatStateUsing(fn(int $state): string => match($state) {
                        1 => __('common.yes'),
                        0 => __('common.no'),
                    })
                    ->color(fn(int $state): string => match($state) {
                        1 => 'success',
                        0 => 'danger',
                    })
            ])
            ->filters([
                SelectFilter::make('active')
                    ->label(__('admin.active'))
                    ->options([
                        1 => __('admin.active'),
                        0 => __('admin.inactive'),
                    ])
            ]);
    }
    public function render(): View
    {
        return view('livewire.partners-table');
    }
}
