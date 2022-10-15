<?php

require_once __DIR__ . '/ServiceBase.php';
require_once __DIR__ . '/../model/data/LineNotifyData.php';


class LineNotifyService
{
  protected LineNotifyData $line_notify_data;

  private LineNotifySendOption $line_notify_send_option;
  private ServiceResultOption $service_result_option;


  public function __construct()
  {
    $this->line_notify_data = new LineNotifyData();
    $this->line_notify_send_option = new LineNotifySendOption();
    $this->service_result_option = new ServiceResultOption();
  }


  public function send_log_message(string $message): ServiceResponse
  {
    return $this->send_message($this->line_notify_send_option->log, $message);
  }


  public function send_alert_message(string $message): ServiceResponse
  {
    return $this->send_message($this->line_notify_send_option->alert, $message);
  }


  public function send_error_message(string $message): ServiceResponse
  {
    return $this->send_message($this->line_notify_send_option->error, $message);
  }


  public function send_success_message(string $message): ServiceResponse
  {
    return $this->send_message($this->line_notify_send_option->success, $message);
  }


  private function send_message(string $type, string $message): ServiceResponse
  {
    // Validate
    if (!in_array($type, get_object_vars($this->line_notify_send_option), true)) {
      return new ServiceResponse($this->service_result_option->failure, "ERROR: Type $type can not Use.");
    }

    // Set Access Token
    $access_token = $this->line_notify_data->access_token_list[$type];

    // Set Options
    $ch = curl_init("https://notify-api.line.me/api/notify");
    $header = [
      "Content-Type: application/x-www-form-urlencoded",
      "Authorization: Bearer $access_token"
    ];
    $query = http_build_query([
      "message" => "\n$message"
    ]);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    curl_close($ch);

    if ($response) {
      return new ServiceResponse($this->service_result_option->success, 'Success Send Message.');
    } else {
      return new ServiceResponse($this->service_result_option->failure, 'ERROR: LINE Notify API failure.');
    }
  }
}


class LineNotifySendOption
{
  public string $log = 'log';
  public string $alert = 'alert';
  public string $error = 'error';
  public string $success = 'success';
}
