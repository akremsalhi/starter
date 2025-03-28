<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GlobalSetting extends Settings
{

    public static function group(): string
    {
        return 'global';
    }
}