<?php

namespace App\Helpers;

use Exception;
use App\Constants\Log\LogTypeConstant;
use App\Objects\Log\LoggingObject;
use App\Services\LineNotifyService;
use App\Services\LogService;

class LogHelper
{
    /**
     * Log
     *
     * @param string $message Message
     * @return void
     */
    public static function log(string $message): void
    {
        LogHelper::loggingDB($message);
        LogHelper::notify($message);
    }

    /**
     * Log
     *
     * @param Exception $exception Exception
     * @return void
     */
    private static function loggingDB(string $message): void
    {
        $logService = new LogService();
        $loggingObject = new LoggingObject(LogTypeConstant::LOG, $message);
        $logService->log($loggingObject);
    }

    /**
     * LINE Notify
     *
     * @param Exception $exception Exception
     * @return void
     */
    private static function notify(string $message): void
    {
        $lineNotifyService = new LineNotifyService();
        $lineNotifyService->sendLogNotify($message);
    }
}
