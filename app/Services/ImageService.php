<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\Company;
use App\Models\Deceased;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    public const LOGO_PATH = 'images/partners/logo/';
    public const BANNER_PATH = 'images/ads/banners/';
    public const DECEASED_IMAGE_PATH = 'images/deceaseds/';
    /**
     * Store company logo
     *
     * @param Request $request Request model
     * @param Company $company Company model
     * @return string|null return logo filename if success, null if failure
     */
    public function storeCompanyLogo(Request $request, Company $company): string|null
    {
        // This can be either logo in tmp file, or logo already saved in images/partners/logo directory
        $source = $request->input('logo');
        // Return null if no source is sent
        if(!$source) {
            // Maybe user is removing logo, check if logo existed and delete
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            return null;
        }

        $isTmpPath = $this->isTmpImagePath($source);
        // return original soruce if it is not tmp source
        if (!$isTmpPath) {
            return $source;
        }

        $filename = pathinfo($source, PATHINFO_BASENAME);
        $destination = self::LOGO_PATH . $filename;

        if (!is_null($company->logo)) {
            Storage::disk('public')->delete($company->logo);
        }

        $dimensions = config('eosmrtnice.image_dimensions.company_logo');

        try {
            Image::read(storage_public_path($source))
                ->cover($dimensions['width'], $dimensions['height'])
                ->save(storage_public_path($destination));
            Storage::disk('public')->delete($source);
            $moved = true;

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $moved = false;
        }

        return $moved ? $destination : null;
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
        $source = $request->input('banner');
        if(!$source) {
            // Maybe user is removing logo, check if logo existed and delete
            if ($ad->banner) {
                Storage::disk('public')->delete($ad->banner);
            }
            return null;
        }

        $isTmpPath = $this->isTmpImagePath($source);
        // return original soruce if it is not tmp source
        if (!$isTmpPath) {
            return $source;
        }

        $filename = pathinfo($source, PATHINFO_BASENAME);
        $destination = self::BANNER_PATH . $filename;

        if (!is_null($ad->banner)) {
            Storage::disk('public')->delete($ad->banner);
        }

        $moved = Storage::disk('public')->move($source, $destination);
        return $moved ? $destination : null;
    }

    /**
     * Store deceased image
     *
     * @param Request $request
     * @param Deceased $deceased
     * @return string|null
     */
    public function storeDeceasedImage(Request $request, Deceased $deceased): string|null
    {
        $source = $request->input('image');

        if(!$source) {
            // Maybe user is removing image, check if image existed and delete
            if ($deceased->image) {
                Storage::disk('public')->delete($deceased->image);
            }
            return null;
        }

        $isTmpPath = $this->isTmpImagePath($source);
        // return original soruce if it is not tmp source
        if (!$isTmpPath) {
            return $source;
        }

        $filename = pathinfo($source, PATHINFO_BASENAME);
        $destination = self::DECEASED_IMAGE_PATH . $filename;

        if (!is_null($deceased->image)) {
            Storage::disk('public')->delete($deceased->image);
        }

        $dimensions = config('eosmrtnice.image_dimensions.deceased_image');

        try {
            Image::read(storage_public_path($source))
                ->cover($dimensions['width'], $dimensions['height'])
                ->save(storage_public_path($destination));
            Storage::disk('public')->delete($source);
            $moved = true;

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $moved = false;
        }

        return $moved ? $destination : null;
    }

    /**
     * Does image path come from tmp directory
     * @param string|null $path
     * @return bool
     */
    public function isTmpImagePath(string|null $path): bool
    {
        return str_starts_with($path, 'tmp/');
    }
}
