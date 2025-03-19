<?php

namespace App\Http\Controllers\Api\V1;

use App\Core\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;

class UserController extends ApiController
{
    public function user (#[CurrentUser] User $user) {
        return $this->respondSuccess($user);
    }
}
