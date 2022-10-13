<?php

class Base
{
  public string $host = '';
  public string $version = '';
  public $body = '';

  protected array $ALLOW_VERSION_LIST = [];


  public function __construct(string $host, string $version, $body)
  {
    $this->host = $host;
    $this->version = $version;
    $this->body = $body;
  }


  protected function check_localhost(): bool
  {
    return $this->host === 'localhost';
  }


  protected function check_version(): bool
  {
    return in_array($this->version, $this->ALLOW_VERSION_LIST, true);
  }
}


class ResponseStyle
{
  public string $status;
  public string $message;


  public function __construct(string $status, string $message)
  {
    $this->status = $status;
    $this->message = $message;
  }
}
