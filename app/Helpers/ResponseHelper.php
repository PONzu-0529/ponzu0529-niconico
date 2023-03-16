<?php

namespace App\Helpers;

class ResponseHelper
{
    /**
     * JSON Response
     *
     * @param array $data
     * @param integer $status (default 200)
     * @return \Illuminate\Http\JsonResponse
     */
    public static function jsonResponse(array $data, int $status = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json($data, $status);
    }

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
