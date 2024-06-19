<?php

namespace App\Http\Livewire\Tables\User;

use App\Models\Deceased;
use App\Models\Post;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
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
            ->columns($this->getColumns())
            ->filters([
                //
            ])
            ->actions($this->getActions())
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

    private function getColumns(): array
    {
        return [
            Split::make([
                TextColumn::make('type')
                    ->label(__('models/post.type'))
                    ->sortable()
                    ->formatStateUsing(fn (Post $post) => $post->type->translate()),
                TextColumn::make('deceased.full_name')
                    ->label(__('models/deceased.full_name'))
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name']),
                Stack::make([
                    TextColumn::make('starts_at')
                        ->label(__('models/post.starts_at'))
                        ->formatStateUsing(fn(Post $p):string => __('models/post.starts_at').': ' . $p->starts_at->format('d.m.Y.')),
                    TextColumn::make('ends_at')
                        ->label(__('models/post.ends_at'))
                        ->formatStateUsing(fn(Post $p):string => __('models/post.ends_at').': ' . $p->ends_at->format('d.m.Y.')),
                ]),
            ]),
        ];
    }

    private function getActions(): array
    {
        return [
            ActionGroup::make([
                EditAction::make('view')
                    ->label(__('common.edit'))
                    ->icon('heroicon-s-pencil-square')
                    ->url(fn(Post $post) => route('user.posts.edit', ['deceased' => $post->deceased_id, 'post' => $post->id])),
            ]),
        ];
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
