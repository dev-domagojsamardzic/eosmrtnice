<?php

namespace App\Http\Controllers\Guest;

use App\Enums\CompanyType;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\County;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyTypeController extends Controller
{
    /**
     * Return default query builder
     * @return Builder
     */
    private function query(): Builder
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
        $funerals = $this->query()->inRandomOrder()->get();

        return view('guest.funerals', compact('counties', 'funerals'));
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
                $query->whereHas('company', function ($query) use ($county) {
                    $query->where('county_id', $county);
                });
            })
            ->when($city, function ($query, $city) {
                $query->whereHas('company', function ($query) use ($city) {
                    $query->whereHas('city', function ($query) use ($city) {
                        $query->where('title', 'LIKE', '%'.$city.'%');
                    });
                });
            })
            ->get()
            ->toArray();

        return response()->json($ads);
    }
}
