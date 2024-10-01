<?php

namespace App\Http\Livewire\Tables;

use App\Models\Ad;
use Exception;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class AdsTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    /**
     * Return configured table
     * @throws Exception
     */
    public function table(Table $table): Table
    {
        return $table
            ->striped()
            ->query($this->getQuery())
            ->emptyStateHeading(__('common.no_records'))
            ->emptyStateDescription('')
            ->columns($this->getColumns())
            ->filters($this->getFilters())
            ->headerActions($this->getHeaderActions())
            ->actions($this->getActions())
            ->groups($this->getGroups());
    }

    /**
     * Render table in a view
     * @return View
     */
    public function render(): View
    {
        return view('livewire.table');
    }

    /**
     * Return query builder
     * @return Builder
     */
    protected function getQuery(): Builder
    {
        return Ad::query()
            ->orderBy('created_at', 'desc');
    }

    /**
     * Return table columns
     * @return array
     */
    protected function getColumns(): array
    {
        return [];
    }

    /**
     * Return table actions
     * @return array
     */
    protected function getActions(): array
    {
        return  [];
    }

    /**
     * Return table header actions
     * @return array
     */
    protected function getHeaderActions(): array
    {
        return [];
    }

    /**
     * Return table filters
     * @return array
     * @throws Exception
     */
    protected function getFilters(): array
    {
        return [];
    }

    /**
     * Return table groups
     * @return array
     */
    protected function getGroups(): array
    {
        return [];
    }
}
