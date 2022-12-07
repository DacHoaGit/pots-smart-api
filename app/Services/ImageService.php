<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use ImageIntervention;

class ImageService
{
    public function updateImage($model, $request, $path, $methodType)
    {
        $image = ImageIntervention::make($request->file('image'));
        if (!empty($model->image)) {
            $currentImage = public_path() . $path . $model->image;

            if (file_exists($currentImage)) {
                unlink($currentImage);
            }
        }

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

       
        $name = time() . '.' . $extension;
        $image->save(public_path() . $path . $name);

        if ($methodType === 'store') {
            $model->user_id = Auth::user()->id;
        }

        $model->image = $name;
        $model->save();

    }
}