<?php

require_once __DIR__ . '/../common/ResponseStyle.php';

require_once __DIR__ . '/../model/data/IpAddressData.php';

require_once __DIR__ . '/../service/LoggingService.php';


class ControllerBase
{
  public string $remote_ip_address = '';
  public string $version = '';
  public $body = '';
  protected array $ALLOW_VERSION_LIST = [];

  protected LoggingService $logging_service;
  private IpAddressData $ip_address_data;


  public function __construct(string $remote_ip_address, string $version, $body)
  {
    $this->remote_ip_address = $remote_ip_address;
    $this->version = $version;
    $this->body = $body;

    $this->logging_service = new LoggingService();
    $this->ip_address_data = new IpAddressData();
  }


  public function check_allow_remote_ip_address(): bool
  {
    $allow_ip_address_list = [];

    $get_allow_ip_address_list_response = $this->ip_address_data->get_allow_ip_address_list();

    if ($get_allow_ip_address_list_response->get_status() === ResponseStatusOption::SUCCESS) {
      $allow_ip_address_list = $get_allow_ip_address_list_response->get_data();
    }

    return in_array($this->remote_ip_address, $allow_ip_address_list, true);
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
