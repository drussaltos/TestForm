<?php
namespace App\Services;

use Intervention\Image\ImageManagerStatic as Image;

class ImageManager
{
    private $folder;

    public function __construct()
    {
        $this->folder = config('uploadsFolder');
    }

    public function uploadImage($image)
    {
        $filename = strtolower(str_random(10)) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
        $image = Image::make($image['tmp_name']);
        $image->save($this->folder . $filename);

        return $filename;
    }
}