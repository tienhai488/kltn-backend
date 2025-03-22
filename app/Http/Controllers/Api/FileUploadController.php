<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    /**
     * Handle a file upload request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('images')) {
            $file = $request->file('images')[0];

            $path = $file->store('uploads', 'public');

            return response()->json($path, 200);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     * Revert a file upload.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function revert(Request $request)
    {
        $filePath = json_decode($request->getContent(), true);

        if ($filePath) {
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
                return response()->json('File deleted', 200);
            }

            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->json(['error' => 'File path missing'], 400);
    }
}
