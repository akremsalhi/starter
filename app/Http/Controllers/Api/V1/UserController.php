<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Users\StoreUserAction;
use App\Core\Http\Controllers\ApiController;
use App\Data\StoreUserData;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;

class UserController extends ApiController
{
    public function me(#[CurrentUser] User $user)
    {
        return $this->respondSuccess($user);
    }

    public function store(
        StoreUserRequest $request,
        StoreUserAction $storeUserAction,
        #[CurrentUser] User $user
    ) {
        
        $user->givePermissionTo('user-create');

        $storeUserResponse = $storeUserAction->handle($request->toDTO());

        if (!$storeUserResponse->isSuccess || !$storeUserResponse->user) {
            return $this->respondError($storeUserResponse->error);
        }

        return $this->respondSuccess($storeUserResponse->user);
    }
}
