<?php

namespace App\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Image;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class StoreUserData extends Data
{
    public function __construct(
        #[Min(4)]
        #[Max(255)]
        public string $name,
        #[Email]
        #[Max(255)]
        public string $email,
        #[Min(8)]
        #[Max(255)]
        #[Confirmed]
        public string $password,
        #[Image]
        #[Max(2048)]
        public ?UploadedFile $image,
    ) {
    }

    public static function authorize(ValidationContext $context): bool
    {
        return $context->fullPayload['name'] === 'John Doe';
    }
}
