<?php

class ServiceResponse
{
  public string $result;
  public string $response;


  public function __construct(string $result, string $response)
  {
    $this->result = $result;
    $this->response = $response;
  }
}


class ServiceResultOption
{
  public string $success = 'success';
  public string $failure = 'failure';
}
