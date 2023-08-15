<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Constants\Log\LogTypeConstant;
use App\Objects\Log\LoggingObject;
use App\Services\LogService;
use Exception;

class LogServiceTest extends TestCase
{
    private LogService $logService;

    public function __construct()
    {
        parent::__construct();

        $this->logService = new LogService();
    }

    public function test_log()
    {
        $loggingObject = new LoggingObject(LogTypeConstant::LOG, 'LogTestMessage');

        $this->logService->log($loggingObject);

        $this->assertTrue(true);
    }

    public function test_error_log()
    {
        try {
            throw new Exception('TestException');
        } catch (Exception $ex) {
            $loggingObject = new LoggingObject(
                LogTypeConstant::ERROR,
                $ex->getMessage(),
                $ex->getFile() . ':' . $ex->getLine(),
                $ex->getTraceAsString()
            );

            $this->logService->log($loggingObject);
        }

        $this->assertTrue(true);
    }
}
