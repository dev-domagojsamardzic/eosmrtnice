<?php

namespace App\Http\Livewire\Tables\User;

use App\Models\Deceased;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class DeceasedsTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading(__('common.no_records'))
            ->emptyStateDescription('')
            ->headerActions([
                CreateAction::make('create')
                    ->label(__('models/deceased.add_deceased'))
                    ->icon('heroicon-m-plus')
                    ->url(route(auth_user_type() . '.deceaseds.create'))
            ])
            ->striped()
            ->query($this->getQuery())
            ->columns([
                //
            ])
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
        return view('livewire.deceaseds-table');
    }

    /**
     * Return table's query builder
     *
     * @return Builder
     */
    private function getQuery(): Builder
    {
        return Deceased::query();
    }
}
