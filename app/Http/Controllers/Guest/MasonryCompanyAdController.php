<?php

namespace App\Http\Controllers\Guest;

use App\Enums\CompanyType;
use App\Models\Ad;
use App\Models\County;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class MasonryCompanyAdController extends CompanyTypeAdController
{
    /**
     * Return default query builder with masonries companies ads
     * @return Builder
     */
    protected function query(): Builder
    {
        return Ad::query()
            ->where('company_type', CompanyType::MASONRY)
            ->where('active', 1)
            ->where('approved', 1)
            ->orderByRaw('CASE WHEN type = 3 THEN 1 ELSE 2 END')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Return view with masonries companies ads
     * @return View
     */
    public function masonries(): View
    {
        $counties = County::query()->orderBy('title')->get();
        $ads = $this->query()->inRandomOrder()->get();
        $title = __('guest.masonries');
        $searchRoute = route('guest.masonries.items');

        return view('guest.ads', compact('title', 'counties', 'ads', 'searchRoute'));
    }
}
