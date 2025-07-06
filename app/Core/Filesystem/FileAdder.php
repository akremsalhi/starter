<?php

namespace App\Core\Filesystem;

use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Http\File as HttpFile;
use Illuminate\Http\UploadedFile as LaravelUploadedFile;
use Illuminate\Support\Facades\Storage;
use Throwable;

class FileAdder {

    protected ?string $disk = null;

    public function __construct(
        private readonly Cloud $filesystem
    )
    {
    }

    public function setDisk (string $disk) {
        $this->disk = $disk;
        $this->filesystem = Storage::disk($disk);
    }

    
    public function store (
        HttpFile|LaravelUploadedFile|string $uploadedFile,
        ?string $directory = '',
        $options = [],
    ): UploadedFile {
        return $this->storeAs(
            uploadedFile: $uploadedFile,
            directory: $directory,
            options: $options,
        );
    }

    public function storeAs (
        HttpFile|LaravelUploadedFile|string $uploadedFile,
        HttpFile|LaravelUploadedFile|string|array|null $directory = '',
        ?string $name = null,
        $options = [],
    ): UploadedFile {

        if ($uploadedFile instanceof LaravelUploadedFile && ! $uploadedFile?->isValid()) {
            return new UploadedFile(
                isSuccess: false,
                error: $uploadedFile?->getErrorMessage()
            );
        }

        try {

            $path = $this->filesystem->putFileAs($uploadedFile, $directory, $name, $options);
            
            if (! $path) {
                return new UploadedFile(
                    isSuccess: false,
                    error: ! app()->isProduction() ? "Failed to upload file: activate throwing exception on disk {$this->disk} to see full error message" : null
                );
            }

        } catch (Throwable $e) {
            return new UploadedFile(
                isSuccess: false,
                error: $e->getMessage()
            );
        }
        

        return new UploadedFile(
            isSuccess: true,
            path: $path
        );
    }

    public function delete (?string $path) {

        if (! $path || ! $this->filesystem->exists($path)) {
            return false;
        }
        return $this->filesystem->delete($path);
    }
    
    public function url (?string $path) {
        if (! $path || ! $this->filesystem->exists($path)) {
            return null;
        }

        return $this->filesystem->url($path);
    }
}

class UploadedFile {
    public function __construct(
        public bool $isSuccess,
        public ?string $path = null,
        public ?string $error = null,
    ) {}
}

