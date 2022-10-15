<?php

require_once __DIR__ . '/Base.php';
require_once __DIR__ . '/../service/ServiceBase.php';
require_once __DIR__ . '/../service/LineNotifyService.php';


class LineNotifyController extends Base
{
  private LineNotifyService $line_notify_service;
  private ServiceResultOption $service_result_option;
  private ResponseStatusOption $response_status_option;


  public function __construct(string $host, string $version, $body)
  {
    parent::__construct($host, $version, $body);

    $this->ALLOW_VERSION_LIST = ['v1'];

    $this->line_notify_service = new LineNotifyService();
    $this->service_result_option = new ServiceResultOption();
    $this->response_status_option = new ResponseStatusOption();
  }


  public function SendLogMessage(): ResponseStyle
  {
    // Validate
    $response = $this->common_validate();
    if ($response->status !== $this->response_status_option->success) {
      return $response;
    }

    // Send Message
    $service_response = $this->line_notify_service->send_log_message($this->body['message']);

    return $this->get_service_response($service_response);
  }


  public function SendAlertMessage(): ResponseStyle
  {
    // Validate
    $response = $this->common_validate();
    if ($response->status !== $this->response_status_option->success) {
      return $response;
    }

    // Send Message
    $service_response = $this->line_notify_service->send_alert_message($this->body['message']);

    return $this->get_service_response($service_response);
  }


  public function SendErrorMessage(): ResponseStyle
  {
    // Validate
    $response = $this->common_validate();
    if ($response->status !== $this->response_status_option->success) {
      return $response;
    }

    // Send Message
    $service_response = $this->line_notify_service->send_error_message($this->body['message']);

    return $this->get_service_response($service_response);
  }


  public function SendSuccessMessage(): ResponseStyle
  {
    // Validate
    $response = $this->common_validate();
    if ($response->status !== $this->response_status_option->success) {
      return $response;
    }

    // Send Message
    $service_response = $this->line_notify_service->send_success_message($this->body['message']);

    return $this->get_service_response($service_response);
  }


  private function common_validate(): ResponseStyle
  {
    // Validate Host
    if (!$this->check_localhost()) {
      return new ResponseStyle(
        $this->response_status_option->failure,
        "This Network is not Accepted."
      );
    }

    // Validate Version
    if (!$this->check_version()) {
      return new ResponseStyle(
        $this->response_status_option->failure,
        "Version $this->version is not accepted."
      );
    }

    // Validate Body Message
    if (!$this->check_body_message()) {
      return new ResponseStyle(
        $this->response_status_option->failure,
        'Parameter \'Message\' is not set.'
      );
    }

    return new ResponseStyle(
      $this->response_status_option->success,
      ''
    );
  }


  private function check_body_message(): bool
  {
    return isset($this->body['message']);
  }


  private function get_service_response(ServiceResponse $service_response): ResponseStyle
  {
    if ($service_response->result === $this->service_result_option->success) {
      return new ResponseStyle(
        $this->response_status_option->success,
        $service_response->response
      );
    } else {
      return new ResponseStyle(
        $this->response_status_option->failure,
        $service_response->response
      );
    }
  }
}
