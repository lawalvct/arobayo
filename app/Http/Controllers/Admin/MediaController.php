<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::with('uploader')->latest()->paginate(24);
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|max:51200' // 50MB max per file
        ]);

        $uploadedMedia = [];

        foreach ($request->file('files') as $file) {
            $filename = time() . '_' . Str::random(8) . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('media', $filename, 'public');

            $type = $this->getFileType($file->getMimeType());

            $media = Media::create([
                'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'filename' => $file->getClientOriginalName(),
                'path' => $path,
                'type' => $type,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'uploaded_by' => auth()->id()
            ]);

            $uploadedMedia[] = $media;
        }

        return response()->json([
            'success' => true,
            'count' => count($uploadedMedia),
            'media' => $uploadedMedia
        ]);
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        Storage::disk('public')->delete($media->path);
        $media->delete();

        return redirect()->route('admin.media.index')->with('success', 'Media deleted successfully');
    }

    private function getFileType($mimeType)
    {
        if (Str::startsWith($mimeType, 'image/')) return 'image';
        if (Str::startsWith($mimeType, 'video/')) return 'video';
        if ($mimeType === 'application/pdf') return 'pdf';
        return 'document';
    }
}
