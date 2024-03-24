<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Admin\MemberController;
use App\Models\Member;
use Carbon\Carbon;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Exception;

class MembersTable extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    /**
     * @throws Exception
     */
    public function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading(__('common.empty'))
            ->striped()
            ->query(
                Member::query()
            )
            ->actions($this->getActions())
            ->columns($this->getColumns())
            ->filters($this->getFilters());
    }
    public function render(): View
    {
        return view('livewire.members-table');
    }

    /**
     * Return table columns
     * @return array
     */
    private function getColumns(): array
    {
        return [
            TextColumn::make('full_name')
            ->label(__('admin.full_name'))
            ->sortable(['first_name','last_name'])
            ->searchable(['first_name','last_name']),
            TextColumn::make('email')
                ->label(__('admin.email'))
                ->searchable()
                ->sortable(),
            TextColumn::make('active')
                ->label(__('admin.active'))
                ->badge()
                ->formatStateUsing(fn(int $state): string => match($state) {
                    1 => __('common.yes'),
                    0 => __('common.no'),
                })
                ->color(fn(int $state): string => match($state) {
                    1 => 'success',
                    0 => 'danger',
                })
                ->sortable(),
            TextColumn::make('created_at')
                ->label(__('admin.created'))
                ->formatStateUsing(fn (Carbon $date): string => $date->format('d.m.Y.'))
        ];
    }

    /**
     * Return table filters
     * @return array
     * @throws Exception
     */
    private function getFilters(): array
    {
        return [
            SelectFilter::make('active')
                ->label(__('admin.active'))
                ->options([
                    1 => __('admin.active'),
                    0 => __('admin.inactive'),
                ])
            ->default(1),
        ];
    }

    /**
     * Return table actions
     * @return array
     */
    private function getActions(): array
    {
        return [
            EditAction::make('edit')
                ->label(__('common.edit'))
                ->icon('heroicon-s-pencil-square')
                ->iconButton()
                ->url(fn (Member $partner): string => route(auth_user_type() . '.members.edit', $partner)),
            DeleteAction::make('delete')
                ->label(__('common.delete'))
                ->icon('heroicon-s-trash')
                ->iconButton()
                ->requiresConfirmation()
                ->modalHeading(__('admin.delete_member'))
                ->modalSubmitActionLabel(__('common.delete'))
                ->action(function(Member $member) { (new MemberController())->destroy($member); }),

        ];
    }
}
