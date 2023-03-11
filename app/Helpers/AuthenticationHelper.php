<?php

namespace App\Helpers;

use App\Services\AuthenticationService;
use Auth, Log;

class AuthenticationHelper
{
    public static function checkAuthentication(string $function_id, string $level)
    {
        if (!Auth::check()) return false;

        $service = new AuthenticationService();
        return $service->checkAuthentication(Auth::user()['id'], $function_id, $level);
    }
}
