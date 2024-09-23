<?php

namespace App\Http\Livewire\Tables\Admin;

use App\Http\Controllers\Guest\CondolenceAddonController;
use App\Models\CondolenceAddon;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Component;

class CondolenceAddonsTable extends Component implements HasForms, HasTable
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
        return CondolenceAddon::query()->orderBy('created_at');
    }

    protected function getColumns(): array
    {
        return [
            TextColumn::make('title')
                ->label(__('models/condolence_addons.title'))
                ->weight(FontWeight::Bold)
                ->searchable(),
            TextColumn::make('price')
                ->label(__('models/condolence_addons.price'))
                ->formatStateUsing(function(CondolenceAddon $addon) {
                    return $addon->price . config('app.currency_symbol');
                })
                ->searchable(false),
            TextColumn::make('created_at')
                ->label(__('models/condolence_addons.created_at'))
                ->date('d.m.Y.'),
        ];
    }

    protected function getActions(): array
    {
        return [
            ActionGroup::make([
                EditAction::make('edit')
                    ->label(__('common.edit'))
                    ->url(fn (CondolenceAddon $addon): string => route(auth_user_type() . '.condolence-addons.edit', ['condolence_addon' => $addon])),
                DeleteAction::make('delete')
                    ->label(__('common.delete'))
                    ->requiresConfirmation()
                    ->modalHeading(__('admin.delete_condolence_addon'))
                    ->modalSubmitActionLabel(__('common.delete'))
                    ->action(function(CondolenceAddon $addon) { (new CondolenceAddonController())->destroy($addon); })
            ]),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create_condolence_addon')
                ->label(__('models/condolence_addons.new_addon'))
                ->icon('heroicon-m-plus')
                ->action(fn (): RedirectResponse|Redirector => redirect()->route(auth_user_type() . '.condolence-addons.create'))
        ];
    }
}
