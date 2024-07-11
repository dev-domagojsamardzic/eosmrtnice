<?php

namespace App\Http\Livewire\Tables\User;

use App\Models\Post;
use App\Http\Livewire\Tables\PostsTable as BasePostsTable;
use Filament\Actions\StaticAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class PostsTable extends BasePostsTable
{
    protected function getQuery(): Builder
    {
        return Post::query()
            ->where('user_id', auth()->id());
    }

    protected function getColumns(): array
    {
        return [
            Split::make([
                Stack::make([
                    TextColumn::make('type')
                        ->label(__('models/post.type'))
                        ->searchable()
                        ->weight(FontWeight::Bold)
                        ->formatStateUsing(fn (Post $post) => $post->type->translate()),
                    TextColumn::make('deceased_full_name_lg')
                        ->label(__('models/post.deceased_full_name'))
                        ->searchable()
                ]),
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

    protected function getActions(): array
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
                    ['post' => $post],
                )),
            ActionGroup::make([
                EditAction::make('edit')
                    ->label(__('common.edit'))
                    ->icon('heroicon-s-pencil-square')
                    ->url(fn(Post $post) => route('user.posts.edit', ['post' => $post->id])),
            ]),
        ];
    }
}
