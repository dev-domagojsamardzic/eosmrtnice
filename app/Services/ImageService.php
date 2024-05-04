<?php

namespace App\Services;

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
}
