<?php

require_once __DIR__ . '/ServiceTestBase.php';

require_once __DIR__ . '/../../common/LogOptions.php';
require_once __DIR__ . '/../../common/ResponseStyle.php';

require_once __DIR__ . '/../../service/LineNotifyService.php';


class LineNotifyServiceTest extends ServiceTestBase
{
  const SERVICE_NAME = 'LineNotifyServiceTest';

  private LineNotifyService $line_notify_service;


  public function __construct()
  {
    parent::__construct();
    $this->line_notify_service = new LineNotifyService();
  }


  public function send_log_message(): ResponseStyle
  {
    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Start Service.'
    ));

    $service_response = $this->line_notify_service->send_log_message('Test Log Message.');

    $service_test_response = $this->common_service_response_test(
      $service_response,
      new ServiceResponse(
        ServiceResultOption::SUCCESS,
        'Success Send Message.'
      )
    );

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      $service_test_response->get_status() === ResponseStatusOption::SUCCESS ? LogTypeOption::LOG : LogTypeOption::ERROR,
      $service_test_response->get_message()
    ));

    return $service_test_response;
  }


  public function send_alert_message(): ResponseStyle
  {
    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Start Service.'
    ));

    $service_response = $this->line_notify_service->send_alert_message('Test Log Message.');

    $service_test_response = $this->common_service_response_test(
      $service_response,
      new ServiceResponse(
        ServiceResultOption::SUCCESS,
        'Success Send Message.'
      )
    );

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      $service_test_response->get_status() === ResponseStatusOption::SUCCESS ? LogTypeOption::LOG : LogTypeOption::ERROR,
      $service_test_response->get_message()
    ));

    return $service_test_response;
  }


  public function send_error_message(): ResponseStyle
  {
    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Start Service.'
    ));

    $service_response = $this->line_notify_service->send_error_message('Test Log Message.');

    $service_test_response = $this->common_service_response_test(
      $service_response,
      new ServiceResponse(
        ServiceResultOption::SUCCESS,
        'Success Send Message.'
      )
    );

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      $service_test_response->get_status() === ResponseStatusOption::SUCCESS ? LogTypeOption::LOG : LogTypeOption::ERROR,
      $service_test_response->get_message()
    ));

    return $service_test_response;
  }


  public function send_success_message(): ResponseStyle
  {
    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Start Service.'
    ));

    $service_response = $this->line_notify_service->send_success_message('Test Log Message.');

    $service_test_response = $this->common_service_response_test(
      $service_response,
      new ServiceResponse(
        ServiceResultOption::SUCCESS,
        'Success Send Message.'
      )
    );

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      $service_test_response->get_status() === ResponseStatusOption::SUCCESS ? LogTypeOption::LOG : LogTypeOption::ERROR,
      $service_test_response->get_message()
    ));

    return $service_test_response;
  }
}
