<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Kdion4891\LaravelLivewireTables\Column;
use Kdion4891\LaravelLivewireTables\TableComponent;

class PartnersTable extends TableComponent
{
    public $table_class = 'table table-hover table-striped';

    public $thead_class = 'thead-dark';

    public $checkbox = true;

    public $sort_attribute = 'created_at';

    public function query(): Builder
    {
        return User::query()->where('type','partner');
    }

    public function columns(): array
    {
        return [
            Column::make('Ime', 'first_name')->searchable()->sortable(),
            Column::make('Prezime', 'last_name')->searchable()->sortable(),
            Column::make('Created At')->searchable()->sortable(),
            Column::make('Updated At')->searchable()->sortable(),
        ];
    }
}
