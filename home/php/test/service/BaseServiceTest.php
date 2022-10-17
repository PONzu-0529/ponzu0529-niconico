<?php

require_once __DIR__ . '/../../service/ServiceBase.php';


class BaseServiceTest
{
  public ServiceResultOption $service_result_option;


  public function __construct()
  {
    $this->service_result_option = new ServiceResultOption();
  }


  public function common_service_response_test(ServiceResponse $service_response, ServiceResponse $true_service_response): string
  {
    if ($service_response->result !== $true_service_response->result) {
      return "ERROR: $service_response->result is not $true_service_response->result.\n";
    }

    if ($service_response->response !== $true_service_response->response) {
      return "ERROR: $service_response->response is not $true_service_response->response.\n";
    }

    return "SUCCESS.\n";
  }
}
