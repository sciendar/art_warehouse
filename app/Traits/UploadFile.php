<?php

namespace App\Traits;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadFile
{
    public function upload_file($file, $folder = null, $name = null)
    {
        if($file == null) { return; }

        $folder = 'documents/' . ($folder ?? now()->format('MY'));

        $file_name = $name != null
            ? $name . '.' . $file->getClientOriginalExtension()
            : Str::random(10) . '.' . $file->getClientOriginalExtension();

        $file->storeAs($folder, $file_name);
        $path = '/storage/' . $folder . '/' . $file_name;

        $this->path = $path;
        if ($path != null) {
            $path = 'documents' . Str::after($path, 'documents');
            if (Storage::disk('public')->exists($path)) {
                $this->size = Storage::disk('public')->size($path);
//            $this->extension = Str::after($path, '.');
            }
        }


        return $this;
    }
}
