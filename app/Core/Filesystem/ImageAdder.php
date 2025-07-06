<?php

namespace App\Core\Filesystem;

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
        UploadedFile $uploadedFile,
        callable $callback
    ) {

        if (! $uploadedFile->isSuccess || ! $uploadedFile->path || ! $this->filesystem->exists($uploadedFile->path)) {
            return false;
        }

        $image = Image::load($uploadedFile->path);

        $path = $callback($image);

        if ($path) {
            return $path;
        }

        return $uploadedFile->path;
    }
}
