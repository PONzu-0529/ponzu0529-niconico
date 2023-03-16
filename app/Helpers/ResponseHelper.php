<?php

namespace App\Helpers;

class ResponseHelper
{
    /**
     * Error JSON Response
     *
     * @param string $message
     * @param integer $status (default 500)
     * @return \Illuminate\Http\JsonResponse
     */
    public static function errorJsonResponse(string $message, int $status = 500): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $message
        ], $status);
    }
}
