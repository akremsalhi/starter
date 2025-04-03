<?php

namespace App\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\File;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Password;

class UserData extends Data
{
    public function __construct(
        #[Min(4)]
        #[Max(255)]
        public string $name,
        #[Email]
        #[Max(255)]
        public string $email,
        #[Password]
        #[Confirmed]
        public string $password,
        #[File]
        public ?UploadedFile $image,
    ) {
    }

    
    public static function authorize(): bool
    {
        return true;
    }
}
