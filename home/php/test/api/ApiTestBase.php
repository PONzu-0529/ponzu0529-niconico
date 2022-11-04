<?php

// require_once __DIR__ . '/../../controller/Base.php';

require_once __DIR__ . '/../../common/Utils.php';
require_once __DIR__ . '/../../common/EnvConstants.php';

require_once __DIR__ . '/../../service/LoggingService.php';


class ApiTestBase
{
  protected LoggingService $logging_service;


  public function __construct()
  {
    $this->logging_service = new LoggingService();
  }


  public static function get_host(): string
  {
    switch (Utils::get_environment()) {
      case EnvConstants::LOCAL:
        return 'http://127.0.0.1';

      case EnvConstants::DEVELOP:
        return 'https://dev-tools.ponzu0529.com';

      case EnvConstants::MASTER:
        return 'https://tools.ponzu0529.com';

      default:
        return '';
    }
  }


  public static function post_api_call_test(ApiCallTestOption $api_call_test_option): ResponseStyle
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
      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        'ERROR: Unexpected Response.'
      );
    }

    $result = get_object_vars($response_obj);

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $result
    );
  }


  public static function CommonPostApiTest(string $service, string $url, array $body = []): ResponseStyle
  {
    LoggingService::record($service, 'Start Controller.');

    $api_call_test_response = ApiTestBase::post_api_call_test(
      new ApiCallTestOption($url, $body)
    );

    if ($api_call_test_response->get_status() !== ResponseStatusOption::SUCCESS) {
      $error_message = strval($api_call_test_response->get_data());

      LoggingService::record_error($service, $error_message);

      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        $error_message
      );
    }

    $compare_response_style_response = Utils::compare_response_style_only_status(
      $api_call_test_response,
      new ResponseStyle(
        ResponseStatusOption::SUCCESS
      )
    );

    if ($compare_response_style_response->get_status() !== ResponseStatusOption::SUCCESS) {
      LoggingService::record_error($service, strval($compare_response_style_response->get_data()));
    } else {
      LoggingService::record($service, strval($compare_response_style_response->get_data()));
    }

    LoggingService::record($service, 'Finish Controller.');

    return $compare_response_style_response;
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
