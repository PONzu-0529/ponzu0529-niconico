<?php

require_once __DIR__ . '/../../service/LoggingService.php';


class LoggingServiceTest extends LoggingService
{
  private LoggingService $logging_service;


  public function __construct()
  {
    $this->logging_service = new LoggingService();
  }


  public function record_log_test(): void
  {
    $this->logging_service->record_log('test', 'test log');
  }
}


$logging_service_test = new LoggingServiceTest();

$logging_service_test->record_log_test();
