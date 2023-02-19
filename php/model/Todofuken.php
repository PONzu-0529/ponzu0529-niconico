<?php

class Todofuken
{
  private $todofuken_all_list = [];


  function __construct()
  {
    require __DIR__ . "/../config/config.php";

    // Connect MySQL
    $mysqli = new mysqli($hostname, $username, $password, $database);

    $result = $mysqli->query(
      "
        SELECT
          `prefecture`,
          `capital`,
          `file`
        FROM
          `todofuken`
        ;
      "
    );

    $this->todofuken_all_list = $result->fetch_all(MYSQLI_ASSOC);
  }


  public function get_todofuken_list(int $num): array
  {
    // Check Item Num
    if ($num > 47) {
      $num = 47;
    }

    $todofuken_list = [];

    while (count($todofuken_list) < $num) {
      $todofuken = $this->todofuken_all_list[mt_rand(0, 46)];

      if (!in_array($todofuken, $todofuken_list)) {
        array_push($todofuken_list, $todofuken);
      }
    }

    return $todofuken_list;
  }


  public function get_file_from_todofuken(string $name): string
  {
    foreach ($this->todofuken_all_list as $todofuken) {
      if ($todofuken["prefecture"] === $name) {
        return $todofuken["file"];
      }
    }

    return "";
  }
}
