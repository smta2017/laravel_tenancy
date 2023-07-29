<?php

namespace App\Helpers;

trait Helper
{

    public static function TestedEnv(): bool
    {
        if (in_array(\env('APP_ENV'), \explode(',', env('TEST_ENVS')))) {
            return true;
        }
        return false;
    }
}
