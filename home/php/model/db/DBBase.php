<?php

class DBBase
{
  public mysqli $mysqli;


  function __construct()
  {
    require __DIR__ . '/../../config/Config.php';

    // Connect MySQL
    $this->mysqli = new mysqli($hostname, $username, $password, $database);
  }


  public static function get_db_connection(): mysqli
  {
    require __DIR__ . '/../../config/Config.php';

    return new mysqli($hostname, $username, $password, $database);
  }
}
