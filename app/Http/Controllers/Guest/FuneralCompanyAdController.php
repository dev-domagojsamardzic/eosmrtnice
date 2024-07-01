<?php

namespace App\Http\Controllers\Guest;

use App\Enums\CompanyType;
use App\Models\Ad;
use App\Models\County;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class FuneralCompanyAdController extends CompanyTypeAdController
{
    /**
     * Return default query builder for funeral companies ads
     * @return Builder
     */
    protected function query(): Builder
    {
        return Ad::query()
            ->with('company')
            ->whereHas('company', function ($query) {
                $query->where('type', CompanyType::FUNERAL);
            })
            ->where('active', 1)
            ->where('approved', 1)
            ->orderByRaw('CASE WHEN type = 3 THEN 1 ELSE 2 END')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Return view with funeral companies ads
     * @return View
     */
    public function funerals(): View
    {
        $counties = County::query()->orderBy('title')->get();
        $ads = $this->query()->inRandomOrder()->get();
        $title = __('guest.funerals');
        $searchRoute = route('guest.funerals.items');

        return view('guest.ads', compact('title', 'counties', 'ads', 'searchRoute'));
    }
}
