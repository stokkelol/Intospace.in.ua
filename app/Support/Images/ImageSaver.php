<?php

namespace App\Support\Images;

use Intervention\Image\Facades\Image;

class ImageSaver
{
    public function save($directorypath, $image)
    {
        $filename = $image->getClientOriginalName();
        $path = public_path($directorypath . $filename);
        Image::make($image->getRealPath())->save($path);

        $filename2 = 'thumbnail_'.$image->getClientOriginalName();
        $path2 = public_path($directorypath . $filename2);
        Image::make($image->getRealPath())->resize(300,300)->save($path2);
    }
}
