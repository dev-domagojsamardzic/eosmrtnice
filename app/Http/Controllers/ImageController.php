<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ImageController extends Controller
{
    /**
     * Upload image resource in tmp file
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        $field = $request->get('field');

        if (!$field) {
            return response()->json([
                'message' => __('common.upload_failed'),
                'class' => 'text-danger',
                'image' => null
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            $field => ['image', 'mimetypes:image/jpeg,image/png,image/webp', 'max:4096'], // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'class' => 'text-danger',
                'image' => null,
            ], 422);
        }

        $file = $request->file($field);

        if ($file->isValid()) {
            try {
                $image = Image::read($file);

                $dimensions = match($field) {
                    'image' => config('eosmrtnice.image_dimensions.deceased_image'),
                    'logo'  => config('eosmrtnice.image_dimensions.company_logo'),
                    'banner' => config('eosmrtnice.image_dimensions.ad_banner'),
                    default => config('eosmrtnice.image_dimensions.default'),
                };

                $image->cover($dimensions['width'], $dimensions['height']);

                $tempFilename = Str::uuid()->toString();
                $saveTmpPath = 'tmp/' . $tempFilename . '.' . $file->getClientOriginalExtension();

                $image->save(storage_public_path($saveTmpPath));

                return response()->json([
                    'message' => __('common.upload_successful'),
                    'class' => 'text-success',
                    'image' => $saveTmpPath,
                ]);
            } catch(Exception $e) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'class' => 'text-danger',
                    'image' => null
                ],500);
            }
        }

        return response()->json([
            'message' => __('common.upload_failed'),
            'class' => 'text-danger',
            'image' => null
        ], 400);
    }

    /**
     * Revert image upload / delete image from tmp file
     * @param Request $request
     * @return void
     */
    public function revert(Request $request):void
    {
        $image = $request->getContent();
        Storage::disk('public')->delete($image);
    }
}
