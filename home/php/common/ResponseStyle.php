<?php

class ResponseStyle
{
  private string $status;
  private $data;


  public function __construct(string $status, $data = NULL)
  {
    $this->status = $status;
    $this->data = $data;
  }


  public function get_status()
  {
    return $this->status;
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
