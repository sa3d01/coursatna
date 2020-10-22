<?php
/**
 * Created by MoWagdy
 * Date: 2019-06-23
 * Time: 10:58 PM
 */

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

if (!function_exists('deleteFileFromServer')) {
    function deleteFileFromServer($filePath)
    {
        if ($filePath != null) {
            $fullFilePath = storage_path('app/public/' . $filePath);
            if (file_exists($fullFilePath)) {
                unlink($fullFilePath);
            }
        }
    }
}

if (!function_exists('uploadImage')) {
    function uploadImage($image, $directoryName, $width = 300, $path = null)
    {
        if ($image != null) {

            if (!$path) {
                $path = 'app/public/images/' . $directoryName . '/';
            }

            $fileName = time() . Str::random() . '.' . $image->getClientOriginalExtension();
            Image::make($image)
                ->resize($width, null, function ($ratio) {
                    $ratio->aspectRatio();
                })
                ->save(storage_path($path . $fileName));
            return 'images/' . $directoryName . '/' . $fileName;
        }
        return null;
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($file, $directoryName, $path = null)
    {
        if ($file != null) {
            if (!$path) {
                $path = 'public/files/' . $directoryName;
            }
            return $file->store($path);
        }
        return null;
    }
}

if (!function_exists('getImageUrl')) {
    function getImageUrl($imagePath)
    {
        /*if (Storage::disk('public')->exists($this->avatar)) {
            return Storage::disk('public')->url($this->avatar);
        }*/
        if ($imagePath) {
            return url('../storage/app/public/' . $imagePath);
        }
        return asset('assets/dashboard/img/avatar/avatar-1.png');
    }
}

if (!function_exists('getFileUrl')) {
    function getFileUrl($filePath)
    {
        if ($filePath) {
            return url('../storage/app/' . $filePath);
        }
        return null;
    }
}

if (!function_exists('getFilePath')) {
    function getFilePath($filePath)
    {
        if ($filePath) {
            return '../storage/app/' . $filePath;
        }
        return null;
    }
}
