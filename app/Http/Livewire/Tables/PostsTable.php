<?php

namespace App\Http\Livewire\Tables;

use App\Models\Post;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class PostsTable extends Component implements HasForms, HasTable
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
            ->actions($this->getActions());
    }

    public function render(): View
    {
        return view('livewire.table');
    }

    protected function getQuery(): Builder
    {
        return Post::query();
    }

    protected function getColumns(): array
    {
        return [];
    }

    protected function getActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
