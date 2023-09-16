<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\LineNotifyService;

class LineNotifyServiceTest extends TestCase
{
    private LineNotifyService $lineNotifyService;

    public function __construct()
    {
        parent::__construct();

        $this->lineNotifyService = new LineNotifyService();
    }

    public function test_send_log_notify()
    {
        $this->lineNotifyService->sendLogNotify('Test Log Message.');

        $this->assertTrue(true);
    }

    public function test_send_error_log_notify()
    {
        $this->lineNotifyService->sendErrorLogNotify('Test Error Log Message.');

        $this->assertTrue(true);
    }
}
