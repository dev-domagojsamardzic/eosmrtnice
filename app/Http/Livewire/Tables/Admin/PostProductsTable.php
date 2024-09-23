<?php

namespace App\Http\Livewire\Tables\Admin;

use App\Http\Controllers\Admin\PostProductController;
use App\Models\PostProduct;
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

class PostProductsTable extends Component implements HasForms, HasTable
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
        return PostProduct::query()->orderBy('created_at');
    }

    protected function getColumns(): array
    {
        return [
            TextColumn::make('title')
                ->label(__('models/post_product.title'))
                ->weight(FontWeight::Bold)
                ->searchable(),
            TextColumn::make('price')
                ->label(__('models/post_product.price'))
                ->formatStateUsing(function(PostProduct $product) {
                    return $product->price . config('app.currency_symbol');
                })
                ->searchable(false),
            TextColumn::make('created_at')
                ->label(__('models/post_product.created_at'))
                ->date('d.m.Y.'),
        ];
    }

    protected function getActions(): array
    {
        return [
            ActionGroup::make([
                EditAction::make('edit')
                    ->label(__('common.edit'))
                    ->url(fn (PostProduct $product): string => route(auth_user_type() . '.post-products.edit', ['post_product' => $product])),
                DeleteAction::make('delete')
                    ->label(__('common.delete'))
                    ->requiresConfirmation()
                    ->modalHeading(__('admin.delete_post_product'))
                    ->modalSubmitActionLabel(__('common.delete'))
                    ->action(function(PostProduct $product) { (new PostProductController())->destroy($product); })
            ]),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create_post_product')
                ->label(__('models/post_product.new_post_product'))
                ->icon('heroicon-m-plus')
                ->action(fn (): RedirectResponse|Redirector => redirect()->route(auth_user_type() . '.post-products.create'))
        ];
    }
}
