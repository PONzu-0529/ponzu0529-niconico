<?php

namespace App\Services;

use App\Models\Authentication;
use App\Models\Constants\AuthenticationConstant;

class AuthenticationService
{
    /**
     * Check Authentication
     *
     * @param integer $user_id UserID
     * @param string $function_id FunctionID
     * @param string $level Level
     * @return bool Authentication
     */
    public function checkAuthentication(int $user_id, string $function_id, string $level): bool
    {
        return Authentication::where([
            AuthenticationConstant::USER_ID => $user_id,
            AuthenticationConstant::FUNCTION_ID => $function_id,
            AuthenticationConstant::AUTHENTICATION_LEVEL => $level
        ])->exists();
    }
}
