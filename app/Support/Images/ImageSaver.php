<?php

namespace App\Support\Images;

use Intervention\Image\Facades\Image;

class ImageSaver
{
    public function saveCover($directorypath, $image)
    {
        $this->save($directorypath, $image);
        $this->saveResized($directorypath, $image);
    }

    public function saveLogo($directorypath, $image)
    {
        $this->save($directorypath, $image);
    }

    public function save($directorypath, $image)
    {
        $filename = $image->getClientOriginalName();
        $path = public_path($directorypath . $filename);
        Image::make($image->getRealPath())->save($path);
    }

    public function saveResized($directorypath, $image)
    {
        $filename = 'thumbnail_'.$image->getClientOriginalName();
        $path = public_path($directorypath . $filename);
        Image::make($image->getRealPath())->resize(300,300)->save($path);
    }
}
