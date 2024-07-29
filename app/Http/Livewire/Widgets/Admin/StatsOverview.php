<?php

namespace App\Http\Livewire\Widgets\Admin;

use App\Models\Ad;
use App\Models\Offer;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    protected function getStats(): array
    {
        $activeAds = Ad::query()
            ->forDisplay()
            ->count();

        $activePosts = Post::query()
            ->forDisplay()
            ->count();

        $activeOffers = Offer::query()
            ->valid()
            ->count();

        return [
            Stat::make(__('dashboard.active_ads'), $activeAds),
            Stat::make(__('dashboard.active_posts'), $activePosts),
            Stat::make(__('dashboard.active_offers'), $activeOffers),
        ];
    }
}
