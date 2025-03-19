<?php

namespace App\Core\Traits;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use JsonSerializable;
use Symfony\Component\HttpFoundation\Response;

trait HasApiResponse
{

    public string $DATA_KEY;
    public string $SUCCESS_KEY;
    public string $ERROR_KEY;

    public function respondSuccess(
        array|Arrayable|JsonSerializable|null $contents = null
    ): JsonResponse {
        $data = $this->morphToArray(data: $contents) ?? [];

        return $this->respondJson(data: [
            $this->DATA_KEY => $data
        ]);
    }

    public function respondOk(
        ?string $message
    ): JsonResponse {
        if (! $message) return $this->respondNoContent();

        return $this->respondJson([
            $this->SUCCESS_KEY => $message
        ]);
    }

    public function respondNoContent(
    ): JsonResponse {
        return $this->respondJson([], Response::HTTP_NO_CONTENT);
    }

    public function respondError(
        ?string $message = null,
        ?string $errorKey = null,
    ): JsonResponse {
        $data = [];
        if ($errorKey) Arr::set($data, 'key', $errorKey);
        return $this->respondJson([
            $this->ERROR_KEY => $message ?? __('messages.Error'), 
            ...$data
        ], Response::HTTP_BAD_REQUEST);
    }

    public function respondNotFound(
        ?string $message = null,
        ?string $errorKey = null,
    ): JsonResponse {
        $data = [];
        if ($errorKey) Arr::set($data, 'key', $errorKey);
        return $this->respondJson([
            $this->ERROR_KEY => $message ?? __('messages.Not Found'), 
            ...$data
        ], Response::HTTP_NOT_FOUND);
    }

    public function respondForbidden(
        ?string $message = null,
        ?string $errorKey = null,
    ): JsonResponse {
        $data = [];
        if ($errorKey) Arr::set($data, 'key', $errorKey);
        return $this->respondJson([
            $this->ERROR_KEY => $message ?? __('messages.Forbidden'), 
            ...$data
        ], Response::HTTP_FORBIDDEN);
    }

    public function respondUnAuthenticated(
        ?string $message = null,
        ?string $errorKey = null,
    ): JsonResponse {
        $data = [];
        if ($errorKey) Arr::set($data, 'key', $errorKey);
        return $this->respondJson([
            $this->ERROR_KEY => $message ?? __('messages.UnAuthenticated'), 
            ...$data
        ], Response::HTTP_UNAUTHORIZED);
    }

    private function morphToArray(array|Arrayable|JsonSerializable|null $data): ?array
    {
        if ($data instanceof Arrayable) {
            return $data->toArray();
        }

        if ($data instanceof JsonSerializable) {
            return $data->jsonSerialize();
        }

        return $data;
    }

    private function respondJson(array $data, int $code = 200): JsonResponse
    {
        return new JsonResponse($data, $code);
    }
}
