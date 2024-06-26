<?php

namespace App\Http\Livewire\Tables\User;

use App\Models\Deceased;
use App\Models\Post;
use Filament\Actions\StaticAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Columns\ToggleColumn;
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
            ->emptyStateDescription(__('models/post.empty_state_description'))
            ->emptyStateActions($this->getEmptyStateActions())
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
                    ->weight(FontWeight::Bold)
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
                TextColumn::make('is_approved')
                ->badge()
                ->formatStateUsing(fn(int $state): string => match($state) {
                    1 => __('models/post.post_approved'),
                    0 => __('models/post.post_not_approved'),
                })
                ->color(fn(int $state): string => match($state) {
                    1 => 'success',
                    0 => 'danger',
                }),
                Stack::make([
                    TextColumn::make('is_active')
                        ->badge(false)
                        ->formatStateUsing(fn () => __('models/post.post_active'))
                        ->size(TextColumnSize::ExtraSmall)
                        ->color('secondary'),
                    ToggleColumn::make('is_active'),
                ])->alignStart(),
            ])->from('md'),

        ];
    }

    private function getActions(): array
    {
        return [
            Action::make('preview')
                ->label(__('common.view'))
                ->iconButton()
                ->icon('heroicon-s-eye')
                ->color('grey-900')
                ->modalHeading('')
                ->modalCancelAction(fn (StaticAction $action) => $action->label(__('common.close')))
                ->modalSubmitAction(false)
                ->modalContent(fn (Post $post): View => view(
                    'partials/post-preview',
                    ['post' => $post, 'deceased' => $post->deceased],
                )),
            ActionGroup::make([
                EditAction::make('edit')
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
                ->disabled(fn() => !auth()->user()->deceaseds()->exists())
                ->action(function (array $data, Post $p): RedirectResponse|Redirector {
                    return redirect()->route(auth_user_type() . '.posts.create',['deceased' => $data['deceased_id']]);
                })
        ];
    }

    private function getEmptyStateActions(): array
    {
        return [
            CreateAction::make('create_deceased')
                ->label(__('models/deceased.add_deceased'))
                ->icon('heroicon-m-plus')
                ->url(route('user.deceaseds.create'))
        ];
    }
}
