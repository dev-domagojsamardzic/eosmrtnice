<?php

namespace App\Http\Livewire\Tables\User;

use App\Models\Deceased;
use App\Models\Post;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class PostsTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading(__('common.no_records'))
            ->emptyStateDescription('')
            ->query($this->getQuery())
            ->striped()
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->headerActions($this->getHeaderActions());
    }

    public function render(): View
    {
        return view('livewire.posts-table');
    }

    private function getQuery(): Builder
    {
        return Post::query()->where('user_id', auth()->id());
    }

    private function getHeaderActions(): array
    {
        return [
            Action::make('create_post')
                ->label(__('models/post.new_post'))
                ->icon('heroicon-m-plus')
                ->form([
                    Select::make('deceased_id')
                        ->label(__('models/post.select_deceased_for_new_post'))
                        ->options(Deceased::query()->where('user_id', auth()->id())->get()->pluck('full_name', 'id')->toArray())
                        ->required(),
                ])
                ->action(function (array $data, Post $p): RedirectResponse|Redirector {
                    return redirect()->route(auth_user_type() . '.posts.create',['deceased' => $data['deceased_id']]);
                })
        ];
    }
}
