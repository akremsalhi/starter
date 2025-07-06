<?php

namespace App\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class StoreUserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?UploadedFile $image,
    ) {
    }
}
