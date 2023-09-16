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
    public static function handleException(Exception $exception): void
    {
        ExceptionHelper::loggingDB($exception);
        ExceptionHelper::notify($exception);
    }

    /**
     * Handle Exception and Return
     *
     * @param Exception $exception Exception
     * @return void
     */
    public static function handleExceptionAndReturn(Exception $exception, int $status = 500): JsonResponse
    {
        ExceptionHelper::handleException($exception);

        return response()->json([
            'message' => $exception->getMessage()
        ], $status);
    }

    /**
     * Log
     *
     * @param Exception $exception Exception
     * @return void
     */
    private static function loggingDB(Exception $exception): void
    {
        $logService = new LogService();
        $loggingObject = new LoggingObject(
            LogTypeConstant::ERROR,
            $exception->getMessage(),
            $exception->getFile() . ':' . $exception->getLine(),
            $exception->getTraceAsString()
        );
        $logService->log($loggingObject);
    }

    /**
     * LINE Notify
     *
     * @param Exception $exception Exception
     * @return void
     */
    private static function notify(Exception $exception): void
    {
        $lineNotifyService = new LineNotifyService();
        $lineNotifyService->sendErrorLogNotify($exception->getMessage());
    }
}
