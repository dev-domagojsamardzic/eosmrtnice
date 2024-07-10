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
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Contracts\View\View;

class PostsTable extends BasePostsTable
{
    protected function getColumns(): array
    {
        return [
            Split::make([
                TextColumn::make('type')
                    ->label(__('models/post.type'))
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->formatStateUsing(fn (Post $post) => $post->type->translate()),
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
                ViewColumn::make('offer_sent')
                    ->view('filament.tables.columns.ad-offer-sent-badge'),
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
                Action::make('create_offer')
                    ->label(__('models/offer.create'))
                    ->visible(fn(Post $post): bool => !$post->offers()->valid()->exists())
                    ->icon('heroicon-s-plus')
                    ->color('black')
                    ->url(fn(Post $post): string => route('admin.posts.offers.create', ['post' => $post])),
            ]),
        ];
    }
}
