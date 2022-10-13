<?php

class DBBase
{
  public mysqli $mysqli;


  function __construct()
  {
    require __DIR__ . '/../../config/config.php';

    // Connect MySQL
    $this->mysqli = new mysqli($hostname, $username, $password, $database);
  }
}
