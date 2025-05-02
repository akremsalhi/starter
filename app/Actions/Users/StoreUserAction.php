<?php

namespace App\Actions\Users;

use App\Data\StoreUserData;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StoreUserAction
{
    public function handle(
        StoreUserData $storeUserData
    ): StoreUserActionResponse {

        if ($storeUserData->image && !$storeUserData->image->isValid()) {
            return new StoreUserActionResponse(
                isSuccess: false,
                error: __('validation.uploaded', ['attribute' => 'image'])
            );
        }

        return DB::transaction(function () use ($storeUserData) {
            $user = User::create($storeUserData->except('image')->toArray());
            if ($storeUserData->image) {
                $user->addMediaFromRequest('image')->toMediaCollection(User::PROFILE_PHOTO);
            }

            return new StoreUserActionResponse(
                isSuccess: true,
                user: $user
            );
        });
    }
}

class StoreUserActionResponse
{
    public function __construct(
        public bool $isSuccess,
        public ?User $user = null,
        public ?string $error = null,
    ) {
    }
}
