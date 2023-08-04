<?php

namespace App\Helpers;

use Intervention\Image\Filters\FilterInterface;

class ImageFilter implements FilterInterface
{
    private $blur;
    const BLUR_VAL = 15;

    public function __construct($blur = null){
        $this->blur = $blur;
    }
    public function applyFilter(\Intervention\Image\Image $image)
    {
        $image->resize(700, 400)
            ->greyscale()
            ->pixelate(6)
            ->blur($this->blur);

        return $image;
    }
}
