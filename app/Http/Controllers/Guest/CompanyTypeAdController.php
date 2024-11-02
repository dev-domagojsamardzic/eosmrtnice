<?php

namespace App\Http\Controllers\Guest;

use App\Enums\AdType;
use App\Models\Ad;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyTypeAdController
{
    /**
     * Return default query builder
     * @return Builder
     */
    protected function query(): Builder
    {
        return Ad::query();
    }

    /**
     * Return items requested through ajax request
     * @param Request $request
     * @return JsonResponse
     */
    public function items(Request $request): JsonResponse
    {
        $county = $request->get('county');
        $city = $request->get('city');

        $ads = $this->query()
            ->when($county, function ($query, $county) {
                $query->whereHas('city', function ($query) use ($county) {
                    $query->whereHas('county', function ($query) use ($county) {
                        $query->where('county_id', $county);
                    });
                });
            })
            ->when($city, function ($query, $city) {
                $query->whereHas('city', function ($query) use ($city) {
                    $query->where("title", "like" , "%$city%");
                });
            })
            ->get();

        if ($ads->isEmpty()) {
            return response()->json([view('partials.ad_preview.no_results')->render()]);
        }

        $html = '';
        foreach ($ads as $ad) {
            $view = match($ad->type) {
                AdType::PREMIUM => 'partials.ad_preview.premium',
                AdType::GOLD => 'partials.ad_preview.gold',
                default => 'partials.ad_preview.standard',
            };

            $html .= view($view, compact('ad'))->render();
        }

        return response()->json([$html]);
    }
}
