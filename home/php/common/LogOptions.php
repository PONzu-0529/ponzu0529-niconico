<?php


class LogStyle
{
  public string $service;
  public string $type;
  public string $log;


  public function __construct(string $service, string $type, string $log)
  {
    $this->service = $service;
    $this->type = $type;
    $this->log = $log;
  }
}


class LogTypeOption
{
  const LOG = 'Log';
  const ERROR = 'Error';
}
