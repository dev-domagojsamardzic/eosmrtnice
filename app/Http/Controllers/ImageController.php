<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'image' => ['image', 'mimes:jpeg,jpg,png,svg+xml,webp', 'max:2048'], // Max 2MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'class' => 'text-danger',
                'image' => null,
            ], 422);
        }

        if ($request->file('logo')) {
            try {
                $image = $request->file('logo')->store('tmp', 'public');
                return response()->json([
                    'message' => __('common.upload_successful'),
                    'class' => 'text-success',
                    'image' => $image,
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

    public function revert(Request $request)
    {
        $image = $request->header('X-Image');
        Storage::disk('public')->delete($request->get('logo'));
    }
}
