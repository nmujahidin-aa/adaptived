<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage as Box;

class Storage
{
    /**
     * Store file to storage
     *
     * @param UploadedFile $file Uploaded file
     * @param ?string $database Database file name (required to replace existing file)
     * @param string|Path $basePath Base path to store file. Retrieved from \App\Helpers\Path (default: 'images')
     * @param string $driver Storage driver (default: 'public')
     * @return string New file name with extension
     */
    public static function store(UploadedFile $file, ?string $database, string|Path $basePath = 'images', string $driver = 'public') : string {
        self::destroy($database, $basePath);
        $fileName = 'img-' . Str::random(10) . '-' . time() . '.' . $file->extension();
        $file->storeAs($basePath, $fileName, $driver);
        return $fileName;
    }

    /**
     * Destroy file from storage
     *
     * @param ?string $database Database file name
     * @param string|Path $basePath Base path origin file. Retrieved from \App\Helpers\Path (default: 'images')
     * @param string $driver Storage driver (default: 'public')
     * @return void
     */
    public static function destroy(?string $database, string|Path $basePath = 'images', string $driver = 'public') : void {
        if ($database) {
            // Box is alias for \Illuminate\Support\Facades\Storage
            $storage = Box::disk($driver);
            if ($storage->exists($basePath . $database)) {
                $storage->delete($basePath . $database);
            }
        }
    }

    /**
     * Get file url from public storage
     *
     * @param string $fileName File name with extension
     * @param string|Path $basePath Base path origin file. Retrieved from \App\Helpers\Path (default: 'images')
     * @return string File public url
     */
    public static function url(string $fileName, string|Path $basePath = 'images') : string {
        return Box::disk('public')->url($basePath . $fileName);
    }
}
