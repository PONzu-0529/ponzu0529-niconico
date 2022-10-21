<?php

require_once __DIR__ . '/../../controller/Base.php';

require_once __DIR__ . '/../../service/LoggingService.php';


class ApiTestBase
{
  protected LoggingService $logging_service;


  public function __construct()
  {
    $this->logging_service = new LoggingService();
  }


  public function post_api_call_test(ApiCallTestOption $api_call_test_option): ControllerResponseStyle
  {
    $ch = curl_init($api_call_test_option->get_url());
    $query = json_encode($api_call_test_option->get_body());

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $response_obj = json_decode($response);

    if ($response_obj === NULL) {
      return new ControllerResponseStyle(
        ControllerResponseStatusOption::FAILURE,
        'ERROR: Unexpected Response.'
      );
    }

    $result = get_object_vars($response_obj);

    return new ControllerResponseStyle(
      $result["status"],
      $result["message"]
    );
  }
}


class ApiCallTestOption
{
  private string $url;
  private array $body;


  public function __construct(string $url, array $body = [])
  {
    $this->url = $url;
    $this->body = $body;
  }


  public function get_url()
  {
    return $this->url;
  }
  public function get_body()
  {
    return $this->body;
  }
}
