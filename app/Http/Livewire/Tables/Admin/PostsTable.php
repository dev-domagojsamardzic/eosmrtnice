<?php

namespace App\Http\Livewire\Tables\Admin;

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
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class PostsTable extends BasePostsTable
{
    protected function getQuery(): Builder
    {
        return Post::query()->orderBy('created_at', 'desc');
    }
    protected function getColumns(): array
    {
        return [
            Split::make([
                Stack::make([
                    TextColumn::make('type')
                        ->label(__('models/post.type'))
                        ->weight(FontWeight::Bold)
                        ->searchable()
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
                TextColumn::make('is_active')
                    ->label(__('models/post.active'))
                    ->badge()
                    ->formatStateUsing(fn(int $state): string => match($state) {
                        1 => __('common.is_active_f'),
                        0 => __('common.is_inactive_f'),
                    })
                    ->color(fn(int $state): string => match($state) {
                        1 => 'success',
                        0 => 'danger',
                    }),
                // TODO: Activate later
                /*ViewColumn::make('offer_sent')
                    ->view('filament.tables.columns.ad-offer-sent-badge'),*/
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
                    ['post' => $post, 'deceased' => $post->deceased],
                )),
            ActionGroup::make([
                Action::make('create_offer')
                    ->label(__('models/offer.create'))
                    ->visible(fn(Post $post): bool => !$post->offers()->valid()->exists())
                    ->icon('heroicon-s-plus')
                    ->color('black')
                    ->url(fn(Post $post): string => route('admin.posts-offers.create', ['post' => $post])),
                EditAction::make('edit')
                    ->label(__('common.edit'))
                    ->icon('heroicon-s-pencil-square')
                    ->url(fn(Post $post) => route('admin.posts.edit', ['post' => $post->id])),
                Action::make('approve')
                    ->label(fn (Post $post): string => $post->is_approved ? __('common.disapprove') : __('common.approve'))
                    ->action(function(Post $post): void {
                        $post->is_approved = !$post->is_approved;
                        $post->save();
                    })
                    ->icon(fn (Post $post): string => $post->is_approved ? 'heroicon-m-x-circle' : 'heroicon-m-check-circle')
                    ->color(fn(Post $post): string => $post->is_approved ? 'danger' : 'success')
                    ->requiresConfirmation(),
                Action::make('activate')
                    ->label(fn (Post $post): string => $post->is_active ? __('common.deactivate') : __('common.activate'))
                    ->action(function(Post $post): void {
                        $post->is_active = !$post->is_active;
                        $post->save();
                    })
                    ->icon(fn (Post $post): string => $post->is_active ? 'heroicon-m-x-circle' : 'heroicon-m-check-circle')
                    ->color(fn(Post $post): string => $post->is_active ? 'danger' : 'success')
                    ->requiresConfirmation(),
            ]),
        ];
    }
}
