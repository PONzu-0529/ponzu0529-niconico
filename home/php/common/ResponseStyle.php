<?php

class ResponseStyle
{
  private string $status;
  private string $message;
  private $data;


  public function __construct(string $status, string $message = '', $data = NULL)
  {
    $this->status = $status;
    $this->message = $message;
    $this->data = $data;
  }


  public function get_status()
  {
    return $this->status;
  }


  public function get_message()
  {
    return $this->message;
  }


  public function get_data()
  {
    return $this->data;
  }
}


class ResponseStatusOption
{
  const SUCCESS = 'success';
  const FAILURE = 'failure';
}
