<?php

namespace App\Http\Controllers\Admin;

use App\Enum\ImageSize;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditorImageUploadController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');

            if ($file->getSize() > ImageSize::MAX_FILE_SIZE->value) {
                return response()->json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => 'Kích thước tệp tin vượt quá giới hạn cho phép (10MB).'
                    ]
                ], 400);
            }

            $originName = $file->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $datePath = now()->format('Y/m/d');
            $path = $file->storeAs("public/media/{$datePath}", $fileName);

            $url = route('admin.load_image', ['file_url' => $path]);

            return response()->json([
                'fileName' => $fileName,
                'uploaded' => true,
                'url' => $url
            ]);
        }
    }
}
