<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class ImageController extends Controller
{
    public function upload(Request $request): JsonResponse
    {
        if ($request->file('logo')) {
            try {
                $image = $request->file('logo')->store('tmp', 'public');
                return response()->json(['message' => 'Upload successful.', 'image' => $image]);
            } catch(Exception $e) {
                return response()->json(['message' => $e->getMessage(), 'image' => null],500);
            }
        }
        return response()->json(['message' => 'Image missing.', 'image' => null], 204);
    }

    public function revert(Request $request)
    {
        Storage::disk('public')->delete($request->getContent());
    }
}
