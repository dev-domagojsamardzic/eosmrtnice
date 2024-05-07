<?php

namespace App\Http\Livewire\Tables\Admin;

use App\Models\Service;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ServicesTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->striped()
            ->query($this->getQuery())
            ->emptyStateHeading(__('common.no_records'))
            ->emptyStateDescription('')
            ->columns($this->getColumns())
            ->filters([])
            ->actions($this->getActions())
            ->headerActions([]);
    }

    public function render(): View
    {
        return view('livewire.services-table');
    }

    /**
     * Return query builder
     * @return Builder
     */
    private function getQuery(): Builder
    {
        return Service::query()
            ->orderBy('active', 'desc')
            ->orderBy('title');
    }

    /**
     * Return table columns
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            TextColumn::make('title')
                ->label(__('models/service.title'))
                ->weight(FontWeight::Bold),
            TextColumn::make('description')
                ->label(__('models/service.description')),
            TextColumn::make('price')
                ->label(__('models/service.price') . '/' . config('app.currency_symbol'))
                ->formatStateUsing(fn (float $state): string => number_format($state, 2) . ' ' . config('app.currency_symbol')),
            ToggleColumn::make('active')
                ->label(__('models/service.active')),
        ];
    }

    /**
     * Return table row actions
     * @return array
     */
    private function getActions(): array
    {
        return  [
            ActionGroup::make([
                Action::make('edit')
                    ->label(__('common.edit'))
                    ->icon('heroicon-s-pencil-square')
                    ->form([
                        TextInput::make('title')
                            ->label(__('models/service.title')),
                        Textarea::make('description'),
                        TextInput::make('price')
                            ->label(__('models/service.price'))
                            ->numeric()
                            ->inputMode('decimal')
                            ->step(0.01),
                    ])
                    ->fillForm(fn (Service $service): array => [
                        'title' => $service->title,
                        'description' => $service->description,
                        'price' => $service->price,
                    ])
                    ->action(function (array $data, Service $service): void {
                        $service->title = $data['title'];
                        $service->description = $data['description'];
                        $service->price = $data['price'];
                        $service->save();
                    })
            ])->iconPosition(IconPosition::Before),
        ];
    }

    /**
     * Return table header actions
     * @return array
     */
    private function getHeaderActions(): array
    {
        return [
            Action::make('create_service')
                ->label(__('models/service.new_service'))
                ->icon('heroicon-m-plus')
                ->form([
                    TextInput::make('title')
                        ->label(__('models/service.title')),
                    Textarea::make('description'),
                    TextInput::make('price')
                        ->label(__('models/service.price'))
                        ->numeric()
                        ->inputMode('decimal')
                        ->step(0.01),
                ])
                ->action(function (array $data): void {
                    $service = new Service();
                    $service->title = $data['title'];
                    $service->description = $data['description'];
                    $service->price = $data['price'];
                    $service->save();
                })
        ];
    }
}
