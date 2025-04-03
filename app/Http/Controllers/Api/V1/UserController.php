<?php

namespace App\Http\Controllers\Api\V1;

use App\Core\Http\Controllers\ApiController;
use App\Data\UserData;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;

class UserController extends ApiController
{
    public function me (#[CurrentUser] User $user) {
        return $this->respondSuccess($user);
    }

    public function store(UserData $userData) {
        $user = User::create($userData->except('image')->toArray());

        if ($userData->image && ! $userData->image->isValid()) {
            return $this->respondError(__('validation.uploaded', ['attribute' => 'image']));
        }

        if ($userData->image) {
            $user->addMediaFromRequest('image')->toMediaCollection(User::PHOTO_COLLECTION); 
        }

        return $this->respondSuccess($userData->except('image'));
    }
}
