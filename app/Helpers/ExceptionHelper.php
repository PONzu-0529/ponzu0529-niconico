<?php

namespace App\Helpers;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Constants\Log\LogTypeConstant;
use App\Objects\Log\LoggingObject;
use App\Services\LineNotifyService;
use App\Services\LogService;

class ExceptionHelper
{
    /**
     * Handle Exception
     *
     * @param Exception $exception Exception
     * @return void
     */
    public static function handleException(Exception $exception, int $status = 500): JsonResponse
    {
        $logService = new LogService();
        $loggingObject = new LoggingObject(
            LogTypeConstant::ERROR,
            $exception->getMessage(),
            $exception->getFile() . ':' . $exception->getLine(),
            $exception->getTraceAsString()
        );
        $logService->log($loggingObject);

        $lineNotifyService = new LineNotifyService();
        $lineNotifyService->sendErrorLogNotify($exception->getMessage());

        return response()->json([
            'message' => $exception->getMessage()
        ], $status);
    }
}
