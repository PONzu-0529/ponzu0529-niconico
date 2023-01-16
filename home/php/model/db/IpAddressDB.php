<?php

require_once __DIR__ . '/DBBase.php';

require_once __DIR__ . '/../../common/ResponseStyle.php';


class IpAddressDB extends DBBase
{
  public function get_allow_ip_address_list(): ResponseStyle
  {
    $ip_address_list = [];

    $sql_result = $this->mysqli->query(
      "
        SELECT
          `ip`
        FROM
          `ip_address`
        WHERE
          control = 'allow'
        ;
      "
    );

    $db_result = $sql_result->fetch_all(MYSQLI_ASSOC);

    foreach ($db_result as $ip_address_info) {
      array_push(
        $ip_address_list,
        $ip_address_info['ip']
      );
    }

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $ip_address_list
    );
  }


  public function get_deny_ip_address_list(): ResponseStyle
  {
    $ip_address_list = [];

    $sql_result = $this->mysqli->query(
      "
        SELECT
          `ip`
        FROM
          `ip_address`
        WHERE
          control = 'deny'
        ;
      "
    );

    $db_result = $sql_result->fetch_all(MYSQLI_ASSOC);

    foreach ($db_result as $ip_address_info) {
      array_push(
        $ip_address_list,
        $ip_address_info['ip']
      );
    }

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $ip_address_list
    );
  }
}
