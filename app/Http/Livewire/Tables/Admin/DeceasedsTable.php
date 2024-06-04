<?php

namespace App\Http\Livewire\Tables\Admin;

use App\Http\Controllers\User\DeceasedController;
use App\Models\Deceased;
use App\Services\ImageService;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\Layout\Split;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
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
            ->headerActions([])
            ->striped()
            ->query($this->getQuery())
            ->columns($this->getColumns())
            ->filters($this->getFilters())
            ->actions($this->getActions())
            ->bulkActions([]);
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

    /**
     * Return table's columns
     *
     * @return array
     */
    private function getColumns(): array
    {
        return [
            Split::make([
                ImageColumn::make('image')
                    ->label(__('models/deceased.image'))
                    ->square()
                    ->size(60)
                    ->grow(false),
                TextColumn::make('full_name')
                    ->weight(FontWeight::Bold)
                    ->label(__('models/deceased.full_name'))
                    ->sortable(['first_name','last_name'])
                    ->searchable(['first_name','last_name']),
                TextColumn::make('lifespan')
                    ->label(__('models/deceased.born_died')),
                Stack::make([
                    TextColumn::make('city.title')
                        ->searchable(),
                    TextColumn::make('county.title')
                        ->searchable(),
                ])
            ])->from('md'),
        ];
    }

    private function getActions(): array
    {
        return [
            ActionGroup::make([
                EditAction::make('edit')
                    ->label(__('common.edit'))
                    ->icon('heroicon-s-pencil-square')
                    ->url(fn(Deceased $d) => route(auth_user_type().'.deceaseds.edit', ['deceased' => $d->id])),
                DeleteAction::make('delete')
                    ->label(__('common.delete'))
                    ->icon('heroicon-m-trash')
                    ->requiresConfirmation()
                    ->modalHeading(__('admin.delete_deceased'))
                    ->modalSubmitActionLabel(__('common.delete'))
                    ->action(function(Deceased $deceased) { (new DeceasedController(new ImageService()))->destroy($deceased); }),
            ]),
        ];
    }

    private function getFilters(): array
    {
        return [];
    }
}
