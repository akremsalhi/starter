<?php

namespace App\Core\Files;

use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Drivers\Gd\Decoders\FilePathImageDecoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\DecoderInterface;
use Intervention\Image\Interfaces\ImageInterface;


class ImageAdder extends FileAdder
{

    public const CONVERTION_DISK = 'local';

    private ImageInterface $image;



    public function __construct(
        private readonly Cloud $filesystem,
    ) {
        parent::__construct($filesystem);
    }

    public function modify(
        UploadReport|UploadedFile $file,
        callable $callback
    ): string|false {

        if ($file instanceof UploadedFile) {
            if (!$file->isValid()) {
                return false;
            }

            $image = $this->read($file);

            return $callback($image);
        }

        if (
            !$file->isSuccess ||
            !$file->value ||
            !$this->filesystem->exists($file->value) ||
            !$image = $this->read($this->filesystem->path($file->value))
        ) {
            return false;
        }

        return $callback($image, $file->value);
    }





    public function read($input, array|DecoderInterface|string $decoders = []): ImageInterface|false
    {
        return ImageManager::gd()->read($input, $decoders);
    }
}
