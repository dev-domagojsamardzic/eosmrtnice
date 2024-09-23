<?php

namespace App\Http\Livewire\Tables\Admin;

use App\Http\Controllers\Admin\AdTypeController;
use App\Models\AdType;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Livewire\Component;

class AdTypesTable extends Component implements HasForms, HasTable
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
        return AdType::query()->orderBy('created_at');
    }

    protected function getColumns(): array
    {
        return [
            TextColumn::make('title')
                ->label(__('models/ad_type.title'))
                ->weight(FontWeight::Bold)
                ->searchable()
                ->sortable(),
            TextColumn::make('duration_months')
                ->label(__('models/ad_type.duration_months'))
                ->searchable(false)
                ->sortable(false),
            TextColumn::make('price')
                ->label(__('models/ad_type.price'))
                ->formatStateUsing(function(AdType $adType) {
                    return $adType->price . config('app.currency_symbol');
                })
                ->searchable(false)
                ->sortable(false),
            TextColumn::make('created_at')
                ->label(__('models/ad_type.created_at'))
                ->date('d.m.Y.'),
        ];
    }

    protected function getActions(): array
    {
        return [
            ActionGroup::make([
                EditAction::make('edit')
                    ->label(__('common.edit'))
                    ->url(fn (AdType $adType): string => route(auth_user_type() . '.ad-types.edit', ['ad_type' => $adType])),
                DeleteAction::make('delete')
                    ->label(__('common.delete'))
                    ->requiresConfirmation()
                    ->modalHeading(__('admin.delete_ad_type'))
                    ->modalSubmitActionLabel(__('common.delete'))
                    ->action(function(AdType $adType) { (new AdTypeController())->destroy($adType); })
            ]),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create_ad_type')
                ->label(__('models/ad_type.new_addon'))
                ->icon('heroicon-m-plus')
                ->action(fn (): RedirectResponse|Redirector => redirect()->route(auth_user_type() . '.ad-types.create'))
        ];
    }
}
