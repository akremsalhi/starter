<?php

namespace App\Core\Files;

use Illuminate\Contracts\Filesystem\Cloud;
use Spatie\Image\Image;


class ImageAdder extends FileAdder
{

    public function __construct(
        private readonly Cloud $filesystem,
    ) {
        parent::__construct($filesystem);
    }

    public function modify(
        UploadReport $uploadReport,
        callable $callback
    ) {

        if (! $uploadReport->isSuccess || ! $this->filesystem->exists($uploadReport->value)) {
            return false;
        }

        $image = Image::load($uploadReport->value);

        $path = $callback($image);

        if ($path) {
            return $path;
        }

        return $uploadReport->value;
    }
}
