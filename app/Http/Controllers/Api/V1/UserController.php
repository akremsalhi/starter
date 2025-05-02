<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Users\StoreUserAction;
use App\Core\Http\Controllers\ApiController;
use App\Data\StoreUserData;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;

class UserController extends ApiController
{
    public function me (#[CurrentUser] User $user) {
        return $this->respondSuccess($user);
    }

    public function store(
        StoreUserData $storeUserData,
        StoreUserAction $storeUserAction
    ) {

        $storeUserResponse = $storeUserAction->handle($storeUserData);

        if (! $storeUserResponse->isSuccess || ! $storeUserResponse->user) {
            return $this->respondError($storeUserResponse->error);
        }

        return $this->respondSuccess($storeUserResponse->user);
    }
}
