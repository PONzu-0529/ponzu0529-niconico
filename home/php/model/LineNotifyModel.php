<?php

require_once __DIR__ . '/Base.php';
require_once __DIR__ . '/data/LineNotifyData.php';


class LineNotifyModel
{
  private LineNotifyData $line_notify_data;

  private array $line_notify_send_message_option_type_list = [
    'log',
    'alert',
    'error',
    'success'
  ];


  public function __construct(LineNotifyData $line_notify_data)
  {
    $this->line_notify_data = $line_notify_data;
  }


  public function send_message(LineNotifySendMessageOption $option): ModelResponseOption
  {
    // Validate
    if (!in_array($option->type, $this->line_notify_send_message_option_type_list, true)) {
      return new ModelResponseOption('failure', "ERROR: Type $option->type can not Use.");
    }

    // Set Access Token
    $access_token = $this->line_notify_data->access_token_list[$option->type];

    // Set Options
    $ch = curl_init("https://notify-api.line.me/api/notify");
    $header = [
      "Content-Type: application/x-www-form-urlencoded",
      "Authorization: Bearer $access_token"
    ];
    $query = http_build_query([
      "message" => "\n$option->message"
    ]);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    curl_close($ch);

    if ($response) {
      return new ModelResponseOption('success', 'Success Send Message.');
    } else {
      return new ModelResponseOption('failure', 'ERROR: LINE Notify API failure.');
    }
  }
}

class LineNotifySendMessageOption
{
  public string $type;
  public string $message;


  public function __construct(string $type, string $message)
  {
    $this->type = $type;
    $this->message = $message;
  }
}
