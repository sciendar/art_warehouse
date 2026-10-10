<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadImage
{
    public function image_default($default): string
    {
        return $default ?? 'admin/assets/images/no_image.jpg';
    }

    public function upload_image($image, $folder = null, $file_name = null, $is_random = true, $extension = null)
    {
        $path       = $this->image_save($image, $folder, $file_name, $extension, $is_random);
        $this->path = $path;
        if ($path != null) {
            $path = 'images' . Str::after($path, 'images');
            if (Storage::disk('public')->exists($path)) {
                $this->size      = Storage::disk('public')->size($path);
                $this->extension = Str::after($path, '.');
            }
//            $this->remove_image($image?->getOriginal('path'));
        }
        return $this;
    }

    public function get_image($default = null)
    {
//        try {
//            if ($this->path == null) {
//                return $this->image_default($default);
//            }
//
//            $image = 'images' . Str::after($this->path, 'images');
//            if ($image == 'images/partners/Mar2026/kB58F9WXIe.png') {
//                dd(Storage::disk('public'));
//                return Storage::disk('public')->exists($image)
//                    ? $this->path // Storage::disk('public')->url()
//                    : $this->image_default($default);
//            }
//dd($image);
//            return Storage::disk('public')->exists($image)
//                ? $this->path // Storage::disk('public')->url()
//                : $this->image_default($default);
//        } catch (\Exception $e) {
//            dd($e->getMessage(), $image, $this->path);
//        }
        return $this->path ?? $this->image_default($default);
    }

    public function image_save($image, $folder, $file_name, $extension, $is_random)
    {
        $is_base64 = Str::contains($image, 'base64');
        $data      = $is_base64
            ? str_replace(' ', '+', Str::after($image, ';base64,'))
            : $image;

        $pathway = $this->pathway($image, $folder, $file_name, $extension, $is_base64, $is_random);
        $is_base64
            ? Storage::disk('public')->put($pathway, base64_decode($data))
            : $data->storeAs($pathway);

        return '/storage/' . $pathway;
    }

    public function pathway($image, $folder, $file_name, $extension, $is_base64, $is_random)
    {
        return $this->image_folder($folder) . $this->file_name($image, $file_name, $extension, $is_base64, $is_random);
    }

    public function image_folder($folder = null): string
    {
        $date = now()->format('MY');
        return 'images/' . ($folder ? $folder . '/' : '') . $date . '/';
    }

    public function file_name($image, $name, $extension, $is_base64, $is_random): string
    {
        if ($extension == null && $is_base64 == true) {
            $mime      = explode(';', $image)[0];
            $extension = explode('/', $mime)[1] ?? 'jpg';
        }

        $name      = $name ?? ($is_random || $is_base64 ? Str::random(10) : $image->getClientOriginalName());
        $extension = $extension ?? 'jpg';
        return $name . '.' . $extension;
    }

    // Вспомогательные функции

    // удаление сторого фото
    public function remove_image($image_del)
    {
        if ($image_del != null) {
            Storage::disk('public')->delete($image_del);
        }
    }

//    public function storage($image, $image_default): string
//    {
//        if ($image == null) {
//            return $this->image_default($image_default);
//        }
//
//        $image = 'images' . Str::after($image, 'images');
////        $image_url = Storage::disk('public')->exists('/' . $image)
//
//        return Storage::disk('public')->exists($image)
//            ? Storage::disk('public')->url($image)
//            : $this->image_default($image_default);
//    }
}
