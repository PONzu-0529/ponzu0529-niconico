<?php

require_once __DIR__ . '/../../common/ResponseStyle.php';

require_once __DIR__ . '/../db/IpAddressDB.php';


class IpAddressData
{
  private array $allow_ip_address_list;
  private array $deny_ip_address_list;

  private IpAddressDB $ip_address_db;


  public function __construct()
  {
    $this->ip_address_db = new IpAddressDB();

    $allow_ip_address_db_response = $this->ip_address_db->get_allow_ip_address_list();

    if ($allow_ip_address_db_response->get_status() === ResponseStatusOption::SUCCESS) {
      $this->allow_ip_address_list = $allow_ip_address_db_response->get_data();
    } else {
      $this->allow_ip_address_list = [];
    }

    $deny_ip_address_db_response = $this->ip_address_db->get_deny_ip_address_list();

    if ($deny_ip_address_db_response->get_status() === ResponseStatusOption::SUCCESS) {
      $this->deny_ip_address_list = $deny_ip_address_db_response->get_data();
    } else {
      $this->deny_ip_address_list = [];
    }
  }


  public function get_allow_ip_address_list(): ResponseStyle
  {
    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $this->allow_ip_address_list
    );
  }


  public function get_deny_ip_address_list(): ResponseStyle
  {
    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $this->deny_ip_address_list
    );
  }
}
