<?php

namespace App\Core\Filesystem;

use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
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
        array|File|string|UploadedFile|null $uploadedFile,
        ?string $directory = '',
        $options = [],
    ): UploadReport {
        return $this->storeAs(
            uploadedFile: $uploadedFile,
            directory: $directory,
            options: $options,
        );
    }

    public function storeAs (
        array|File|string|UploadedFile|null $uploadedFile,
        string $directory = '',
        ?string $name = null,
        $options = [],
    ): UploadReport {

        if ($uploadedFile instanceof UploadedFile && ! $uploadedFile?->isValid()) {
            return new UploadReport(
                isSuccess: false,
                error: $uploadedFile?->getErrorMessage()
            );
        }

        try {

            $path = $this->filesystem->putFileAs($uploadedFile, $directory, $name, $options);
            
            if (! $path) {
                return new UploadReport(
                    isSuccess: false,
                    error: ! app()->isProduction() ? "Failed to upload file activate filesystem throwing exception to see the full error message" : null
                );
            }

        } catch (Throwable $e) {
            return new UploadReport(
                isSuccess: false,
                error: $e->getMessage()
            );
        }
        

        return new UploadReport(
            isSuccess: true,
            value: $path
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

class UploadReport {
    public function __construct(
        public bool $isSuccess,
        public ?string $value = null,
        public ?string $error = null,
    ) {}
}

