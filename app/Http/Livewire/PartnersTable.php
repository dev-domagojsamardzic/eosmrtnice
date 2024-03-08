<?php

namespace App\Http\Livewire;

use App\Enums\UserType;
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;

class PartnersTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()->where('type', UserType::PARTNER))
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('first_name'),
                TextColumn::make('last_name'),
            ]);
    }
    public function render(): View
    {
        return view('livewire.partners-table');
    }
}
