<?php

require_once __DIR__ . '/../../common/ResponseStyle.php';

require_once __DIR__ . '/../../service/ServiceBase.php';


class ServiceTestBase extends ServiceBase
{
  public function common_service_response_test(ServiceResponse $service_response, ServiceResponse $true_service_response): ResponseStyle
  {
    if ($service_response->result !== $true_service_response->result) {
      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        "ERROR: $service_response->result is not $true_service_response->result."
      );
    }

    if ($service_response->response !== $true_service_response->response) {
      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        "ERROR: $service_response->response is not $true_service_response->response."
      );
    }

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS
    );
  }
}
