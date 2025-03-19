<?php

namespace App\Core\Http\Controllers;

use App\Core\Contracts\WithApiResponse;
use App\Core\Traits\HasApiResponse;

class ApiController extends Controller implements WithApiResponse
{
    use HasApiResponse;

    public function __construct() {
        $this->DATA_KEY = config('globals.api.DATA_KEY');
        $this->SUCCESS_KEY = config('globals.api.SUCCESS_KEY');
        $this->ERROR_KEY = config('globals.api.ERROR_KEY');
    }
}
