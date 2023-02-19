<?php

class LineNotify
{
  public $log_access_token = '';
  public $alert_access_token = '';
  public $error_access_token = '';
  public $success_access_token = '';

  function __construct()
  {
    require __DIR__ . '/../config/config.php';

    // Connect MySQL
    $mysqli = new mysqli($hostname, $username, $password, $database);

    $result = $mysqli->query(
      "
        SELECT
          `type`,
          `access_token`
        FROM
          `line_notify_access_tokens`
        ;
      "
    );

    $result_list = $result->fetch_all(MYSQLI_ASSOC);

    // Set Access Token
    foreach ($result_list as $line_notify) {
      switch ($line_notify['type']) {
        case 'log':
          $this->log_access_token = $line_notify['access_token'];
          break;

        case 'alert':
          $this->alert_access_token = $line_notify['access_token'];
          break;

        case 'error':
          $this->error_access_token = $line_notify['access_token'];
          break;

        case 'success':
          $this->success_access_token = $line_notify['access_token'];
          break;

        default:
          break;
      }
    }
  }

  public function sned_message($info)
  {
    // Check Validation
    if (!isset($info->type)) {
      return "ERROR: Param \"type\" is not Set.";
    } elseif (!in_array($info->type, ["log", "alert", "error", "success"])) {
      return "ERROR: Type \"$info->type\" is not Registered.";
    } elseif (!isset($info->message)) {
      return "ERROR: Param \"message\" is not Set.";
    }

    // Set Access Token
    switch ($info->type) {
      case 'log':
        $access_token = $this->log_access_token;
        break;

      case 'alert':
        $access_token = $this->alert_access_token;
        break;

      case 'error':
        $access_token = $this->error_access_token;
        break;

      case 'success':
        $access_token = $this->success_access_token;
        break;

      default:
        break;
    }

    // Set Options
    $ch = curl_init("https://notify-api.line.me/api/notify");
    $header = [
      "Content-Type: application/x-www-form-urlencoded",
      "Authorization: Bearer $access_token"
    ];
    $query = http_build_query([
      "message" => "\n$info->message"
    ]);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);

    $response = curl_exec($ch);

    curl_close($ch);

    if ($response) {
      return "success";
    } else {
      return "ERROR: LINE Notify API Failure.";
    }
  }
}
