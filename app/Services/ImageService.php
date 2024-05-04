<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Store company logo
     *
     * @param Request $request Request model
     * @param Company $company Company model
     * @return string|null return logo filename if success, null if failure
     */
    public function storeCompanyLogo(Request $request, Company $company): string|null
    {
        $logo = $request->input('logo');
        if(!$logo) {
            return $logo;
        }
        $filename = pathinfo($logo, PATHINFO_BASENAME);

        if (!is_null($company->logo)) {
            Storage::disk('public')->delete('images/partners/logo/' . $company->logo);
        }

        $moved = Storage::disk('public')->move($logo, 'images/partners/logo/' . $filename);
        return $moved ? $filename : null;
    }

    /**
     * Store ad banner image
     *
     * @param Request $request
     * @param Ad $ad
     * @return string|null
     */
    public function storeAdBanner(Request $request, Ad $ad): string|null
    {
        $banner = $request->input('banner');
        if(!$banner) {
            return $banner;
        }
        $filename = pathinfo($banner, PATHINFO_BASENAME);

        if (!is_null($ad->banner)) {
            Storage::disk('public')->delete('images/ads/banner/' . $ad->banner);
        }

        $moved = Storage::disk('public')->move($banner, 'images/ads/banner/' . $filename);
        return $moved ? $filename : null;
    }
}
