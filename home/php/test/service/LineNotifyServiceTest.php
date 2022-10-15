<?php

require_once __DIR__ . '/../../service/LineNotifyService.php';
require_once __DIR__ . '/../../model/data/LineNotifyDataMock.php';


class LineNotifyServiceTest extends LineNotifyService
{
  public function __construct(bool $is_use_mock = false)
  {
    if ($is_use_mock) {
      $this->line_notify_data = new LineNotifyDataMock();
    } else {
      parent::__construct();
    }
  }
}


$line_notify_service_test = new LineNotifyServiceTest();

var_dump($line_notify_service_test->send_log_message('Test Log Message.'));
var_dump($line_notify_service_test->send_alert_message('Test Alert Message.'));
var_dump($line_notify_service_test->send_error_message('Test Error Message.'));
var_dump($line_notify_service_test->send_success_message('Test Success Message.'));
