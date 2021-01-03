<?php
declare(strict_types=1);

namespace App\Support\Images;

use Intervention\Image\Facades\Image;

/**
 * Class ImageSaver
 *
 * @package App\Support\Images
 */
class ImageSaver
{
    /**
     * @param $directorypath
     * @param $image
     * @return void
     */
    public function saveCover($directorypath, $image): void
    {
        $this->save($directorypath, $image);
        $this->saveResized($directorypath, $image);
    }

    /**
     * @param $directorypath
     * @param $image
     * @return void
     */
    public function saveLogo($directorypath, $image): void
    {
        $this->save($directorypath, $image);
    }

    public function save($directorypath, $image): void
    {
        $filename = $image->getClientOriginalName();
        $path = public_path($directorypath . $filename);
        Image::make($image->getRealPath())->save($path);
    }

    public function saveResized($directorypath, $image): void
    {
        $filename = 'thumbnail_'.$image->getClientOriginalName();
        $path = public_path($directorypath . $filename);
        Image::make($image->getRealPath())->resize(300,300)->save($path);
    }
}
