<?php


namespace App\Services;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    public function saveMedia(UploadedFile $file): string
    {
        $filename = Str::random(32) . time() . '.' . $file->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('cover_image/', $file, $filename);
        return 'cover_image/' . $filename;
    }

    public function deleteMedia(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }
}
