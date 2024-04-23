<?php

namespace App\Http\Livewire\Tables\Partner;

use App\Models\Ad;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AdsTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->striped()
            ->emptyStateHeading(__('common.no_records'))
            ->emptyStateDescription('')
            ->headerActions([
                CreateAction::make('create')
                    ->label(__('models/ad.new_ad'))
                    ->icon('heroicon-m-plus')
                    ->url(route(auth_user_type() . '.ads.create'))
                    ->disabled(!auth()->user()->can('create', Ad::class ))
            ])
            ->query(Ad::query())
            ->columns($this->getColumns())
            ->filters($this->getFilters())
            ->actions($this->getActions());
    }

    public function render(): View
    {
        return view('livewire.ads-table');
    }

    /**
     * Return table columns
     * @return array
     */
    private function getColumns(): array
    {
        return [];
    }

    /**
     * Return table filters
     * @return array
     */
    private function getFilters(): array
    {
        return [];
    }

    /**
     * Return table actions
     * @return array
     */
    private function getActions(): array
    {
        return  [];
    }

    /**
     * Return table groups
     * @return array
     */
    private function getGroups(): array
    {
        return [];
    }


}
