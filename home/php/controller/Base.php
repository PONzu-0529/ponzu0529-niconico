<?php

require_once __DIR__ . '/../common/ResponseStyle.php';

require_once __DIR__ . '/../service/LoggingService.php';


class ControllerBase
{
  public string $host = '';
  public string $version = '';
  public $body = '';

  protected LoggingService $logging_service;

  protected array $ALLOW_VERSION_LIST = [];


  public function __construct(string $host, string $version, $body)
  {
    $this->host = $host;
    $this->version = $version;
    $this->body = $body;

    $this->logging_service = new LoggingService();
  }


  protected function check_localhost(): bool
  {
    return $this->host === 'localhost';
  }


  protected function check_version(): bool
  {
    return in_array($this->version, $this->ALLOW_VERSION_LIST, true);
  }
}


class ControllerResponseStyle
{
  public string $status;
  public string $message;


  public function __construct(string $status, string $message)
  {
    $this->status = $status;
    $this->message = $message;
  }  
}


function compare_controller_response_style(
  ControllerResponseStyle $controller_response_style_1,
  ControllerResponseStyle $controller_response_style_2
): ResponseStyle {
  if ($controller_response_style_1->status !== $controller_response_style_2->status) {
    return new ResponseStyle(
      ResponseStatusOption::FAILURE,
      "$controller_response_style_1->status is not $controller_response_style_2->status."
    );
  }

  if ($controller_response_style_1->message !== $controller_response_style_2->message) {
    return new ResponseStyle(
      ResponseStatusOption::FAILURE,
      "$controller_response_style_1->message is not $controller_response_style_2->message."
    );
  }

  return new ResponseStyle(
    ResponseStatusOption::SUCCESS,
    "Each Result is Equal."
  );
}


class ControllerResponseStatusOption
{
  const SUCCESS = 'success';
  const FAILURE = 'failure';
}
