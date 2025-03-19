<?php

namespace App\Core\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use JsonSerializable;

interface WithApiResponse
{
    public function respondSuccess (array|Arrayable|JsonSerializable|null $contents = null): JsonResponse;
    public function respondOk (?string $message): JsonResponse;
    public function respondNoContent (): JsonResponse;
    public function respondError (?string $message = null, ?string $errorKey = null): JsonResponse;
    public function respondNotFound (?string $message = null, ?string $errorKey = null): JsonResponse;
    public function respondForbidden (?string $message = null, ?string $errorKey = null): JsonResponse;
    public function respondUnAuthenticated (?string $message = null, ?string $errorKey = null): JsonResponse;
}
