<?php

require_once __DIR__ . '/Base.php';

require_once __DIR__ . '/../common/LogOptions.php';
require_once __DIR__ . '/../service/LoggingService.php';

require_once __DIR__ . '/../service/ServiceBase.php';
require_once __DIR__ . '/../service/LineNotifyService.php';


class LineNotifyController extends ControllerBase
{
  const SERVICE_NAME = 'LineNotifyController';

  private LineNotifyService $line_notify_service;
  private ServiceResultOption $service_result_option;


  public function __construct(string $host, string $version, $body)
  {
    parent::__construct($host, $version, $body);

    $this->ALLOW_VERSION_LIST = ['v1'];

    $this->line_notify_service = new LineNotifyService();
    $this->service_result_option = new ServiceResultOption();
  }


  public function SendLogMessage(): ControllerResponseStyle
  {
    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Start Service.'
    ));

    // Validate
    $response = $this->common_validate();
    if ($response->status !== ControllerResponseStatusOption::SUCCESS) {
      $this->logging_service->record_log(new LogStyle(
        $this::SERVICE_NAME,
        LogTypeOption::ERROR,
        $response->body
      ));

      return $response;
    }

    // Send Message
    $service_response = $this->line_notify_service->send_log_message($this->body['message']);

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      $service_response->response
    ));

    return $this->get_service_response($service_response);
  }


  public function SendAlertMessage(): ControllerResponseStyle
  {
    // Validate
    $response = $this->common_validate();
    if ($response->status !== ControllerResponseStatusOption::SUCCESS) {
      return $response;
    }

    // Send Message
    $service_response = $this->line_notify_service->send_alert_message($this->body['message']);

    return $this->get_service_response($service_response);
  }


  public function SendErrorMessage(): ControllerResponseStyle
  {
    // Validate
    $response = $this->common_validate();
    if ($response->status !== ControllerResponseStatusOption::SUCCESS) {
      return $response;
    }

    // Send Message
    $service_response = $this->line_notify_service->send_error_message($this->body['message']);

    return $this->get_service_response($service_response);
  }


  public function SendSuccessMessage(): ControllerResponseStyle
  {
    // Validate
    $response = $this->common_validate();
    if ($response->status !== ControllerResponseStatusOption::SUCCESS) {
      return $response;
    }

    // Send Message
    $service_response = $this->line_notify_service->send_success_message($this->body['message']);

    return $this->get_service_response($service_response);
  }


  private function common_validate(): ControllerResponseStyle
  {
    // Validate Host
    if (!$this->check_allow_remote_ip_address()) {
      return new ControllerResponseStyle(
        ControllerResponseStatusOption::FAILURE,
        "This IP Address is not Accepted."
      );
    }

    // Validate Version
    if (!$this->check_version($this->ALLOW_VERSION_LIST)) {
      return new ControllerResponseStyle(
        ControllerResponseStatusOption::FAILURE,
        "Version $this->version is not accepted."
      );
    }

    // Validate Body Message
    if (!$this->check_body_message()) {
      return new ControllerResponseStyle(
        ControllerResponseStatusOption::FAILURE,
        'Parameter \'Message\' is not set.'
      );
    }

    return new ControllerResponseStyle(
      ControllerResponseStatusOption::SUCCESS,
      ''
    );
  }


  private function check_body_message(): bool
  {
    return isset($this->body['message']);
  }


  private function get_service_response(ServiceResponse $service_response): ControllerResponseStyle
  {
    if ($service_response->result === ServiceResultOption::SUCCESS) {
      return new ControllerResponseStyle(
        ControllerResponseStatusOption::SUCCESS,
        $service_response->response
      );
    } else {
      return new ControllerResponseStyle(
        ControllerResponseStatusOption::FAILURE,
        $service_response->response
      );
    }
  }
}
